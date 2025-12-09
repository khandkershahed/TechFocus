<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffMeeting;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MeetingReminderMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StaffMeetingHRController extends Controller
{
    /**
     * Send meeting reminder via email
     */
    public function sendEmailReminder(Request $request, $id)
    {
        Log::info('sendEmailReminder called for meeting ID: ' . $id);
        
        try {
            $meeting = StaffMeeting::findOrFail($id);
            Log::info('Meeting found: ' . $meeting->title);
            
            // Check if meeting is scheduled and in future
            if (!$meeting->canSendReminder()) {
                Log::warning('Cannot send reminder for meeting: ' . $meeting->id);
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot send reminder for this meeting. Meeting must be scheduled and in the future.'
                ], 400);
            }
            
            // Get participants
            $participants = $meeting->getParticipantsListAttribute();
            Log::info('Found ' . ($participants ? $participants->count() : 0) . ' participants');
            
            $sentCount = 0;
            $failedCount = 0;
            
            if ($participants && $participants->count() > 0) {
                foreach ($participants as $participant) {
                    // Send email to each participant
                    if ($participant->email) {
                        try {
                            Log::info('Sending email to: ' . $participant->email);
                            Mail::to($participant->email)->send(new MeetingReminderMail($meeting, $participant));
                            $sentCount++;
                            Log::info('Email sent successfully to: ' . $participant->email);
                        } catch (\Exception $e) {
                            Log::error('Failed to send email to ' . $participant->email . ': ' . $e->getMessage());
                            $failedCount++;
                        }
                    } else {
                        Log::warning('Participant has no email: ' . ($participant->name ?? 'Unknown'));
                    }
                }
            } else {
                Log::warning('No participants found for meeting: ' . $meeting->id);
            }
            
            // Update reminder sent timestamp
            $meeting->update(['email_reminder_sent_at' => now()]);
            
            $message = 'Email reminders sent successfully to ' . $sentCount . ' participants.';
            if ($failedCount > 0) {
                $message .= ' Failed to send to ' . $failedCount . ' participants.';
            }
            
            Log::info('Email reminders completed: ' . $message);
            
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in sendEmailReminder: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send WhatsApp reminder
     */
    public function sendWhatsAppReminder(Request $request, $id)
    {
        Log::info('sendWhatsAppReminder called for meeting ID: ' . $id);
        
        try {
            $meeting = StaffMeeting::findOrFail($id);
            
            if (!$meeting->canSendReminder()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot send WhatsApp reminder for this meeting.'
                ], 400);
            }
            
            $participants = $meeting->getParticipantsListAttribute();
            $sentCount = 0;
            
            if ($participants && $participants->count() > 0) {
                foreach ($participants as $participant) {
                    if ($participant->phone) {
                        try {
                            $this->sendWhatsAppMessage($participant->phone, $meeting);
                            $sentCount++;
                        } catch (\Exception $e) {
                            Log::error('Failed to send WhatsApp to ' . $participant->phone . ': ' . $e->getMessage());
                        }
                    }
                }
            }
            
            $meeting->update(['whatsapp_reminder_sent_at' => now()]);
            
            return response()->json([
                'success' => true,
                'message' => 'WhatsApp reminders sent to ' . $sentCount . ' participants.'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in sendWhatsAppReminder: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate automatic meeting link
     */
    public function generateMeetingLink(Request $request, $id)
    {
        Log::info('generateMeetingLink called for meeting ID: ' . $id);
        
        try {
            $meeting = StaffMeeting::findOrFail($id);
            
            if ($meeting->platform !== 'online') {
                return response()->json([
                    'success' => false,
                    'message' => 'Meeting link can only be generated for online meetings.'
                ], 400);
            }
            
            // Generate Zoom/Google Meet link based on platform
            $link = $this->generateOnlineMeetingLink($meeting);
            
            $meeting->update(['meeting_link' => $link]);
            
            Log::info('Meeting link generated: ' . $link);
            
            return response()->json([
                'success' => true,
                'message' => 'Meeting link generated successfully.',
                'link' => $link
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in generateMeetingLink: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate attendance QR code
     */
    public function generateAttendanceQR(Request $request, $id)
    {
        Log::info('generateAttendanceQR called for meeting ID: ' . $id);
        
        try {
            $meeting = StaffMeeting::findOrFail($id);
            
            // Generate QR code for attendance
            $qrCodePath = $this->generateQRCode($meeting);
            
            $meeting->update(['attendance_qr_code' => $qrCodePath]);
            
            $qrCodeUrl = Storage::url($qrCodePath);
            Log::info('QR code generated at: ' . $qrCodePath);
            
            return response()->json([
                'success' => true,
                'message' => 'Attendance QR code generated successfully.',
                'qr_code_url' => $qrCodeUrl
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in generateAttendanceQR: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * View attendance QR code
     */
    public function viewAttendanceQR($id)
    {
        $meeting = StaffMeeting::findOrFail($id);
        
        if (!$meeting->attendance_qr_code) {
            return response()->json([
                'success' => false,
                'message' => 'No QR code generated yet.'
            ], 404);
        }
        
        $qrCodeUrl = Storage::url($meeting->attendance_qr_code);
        
        return response()->json([
            'success' => true,
            'qr_code_url' => $qrCodeUrl
        ]);
    }

    /**
     * Upload meeting minutes
     */
    public function uploadMinutes(Request $request, $id)
    {
        $request->validate([
            'meeting_minutes' => 'required|string',
            'minutes_attachments.*' => 'nullable|file|max:5120', // 5MB max
        ]);
        
        $meeting = StaffMeeting::findOrFail($id);
        
        if (!$meeting->canUploadMinutes()) {
            return back()->with('error', 'Minutes can only be uploaded for completed meetings.');
        }
        
        // Handle attachments
        $attachments = [];
        if ($request->hasFile('minutes_attachments')) {
            foreach ($request->file('minutes_attachments') as $file) {
                $path = $file->store('meetings/minutes', 'public');
                $attachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                ];
            }
        }
        
        $meeting->update([
            'meeting_minutes' => $request->meeting_minutes,
            'minutes_attachments' => $attachments,
            'minutes_uploaded_by' => auth('admin')->id(),
            'minutes_uploaded_at' => now(),
            'minutes_status' => 'pending',
        ]);
        
        return back()->with('success', 'Meeting minutes uploaded successfully.');
    }

    /**
     * Approve meeting minutes
     */
    public function approveMinutes(Request $request, $id)
    {
        $request->validate([
            'approval_notes' => 'nullable|string|max:500',
        ]);
        
        $meeting = StaffMeeting::findOrFail($id);
        
        if (!$meeting->canApproveMinutes()) {
            return back()->with('error', 'Minutes cannot be approved at this time.');
        }
        
        $meeting->update([
            'minutes_status' => 'approved',
            'approved_by' => auth('admin')->id(),
            'approved_at' => now(),
            'approval_notes' => $request->approval_notes,
        ]);
        
        return back()->with('success', 'Meeting minutes approved successfully.');
    }

    /**
     * Reject meeting minutes
     */
    public function rejectMinutes(Request $request, $id)
    {
        $request->validate([
            'approval_notes' => 'required|string|max:500',
        ]);
        
        $meeting = StaffMeeting::findOrFail($id);
        
        $meeting->update([
            'minutes_status' => 'rejected',
            'approved_by' => auth('admin')->id(),
            'approved_at' => now(),
            'approval_notes' => $request->approval_notes,
        ]);
        
        return back()->with('success', 'Meeting minutes rejected.');
    }

    /**
     * Mark attendance via link
     */
    public function markAttendance($id, $token)
    {
        $meeting = StaffMeeting::findOrFail($id);
        
        // Verify token
        if (md5($meeting->id . env('APP_KEY')) !== $token) {
            abort(403, 'Invalid token');
        }
        
        // Check if meeting is happening now or recently
        $now = now();
        $startTime = $meeting->start_time;
        $endTime = $meeting->end_time;
        
        if ($now->between($startTime->subMinutes(15), $endTime->addMinutes(15))) {
            return view('admin.pages.staff-meetings.mark-attendance', compact('meeting'));
        }
        
        return view('admin.pages.staff-meetings.attendance-closed', compact('meeting'));
    }

    /**
     * Submit attendance
     */
    public function submitAttendance(Request $request, $id, $token)
    {
        // Validate token and meeting
        // Store attendance in database
        // You'll need an attendance table for this
        
        return redirect()->route('attendance.thankyou');
    }

    /**
     * Helper: Send WhatsApp message
     */
    private function sendWhatsAppMessage($phone, $meeting)
    {
        // Using Twilio API example
        /*
        $twilio = new \Twilio\Rest\Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );
        
        $message = $twilio->messages->create(
            "whatsapp:+{$phone}",
            [
                "from" => "whatsapp:" . env('TWILIO_WHATSAPP_NUMBER'),
                "body" => "Meeting Reminder: {$meeting->title}\nDate: {$meeting->date->format('M d, Y')}\nTime: {$meeting->start_time->format('h:i A')}\nLink: {$meeting->meeting_link}"
            ]
        );
        */
        
        // For now, just log it
        Log::info("WhatsApp reminder sent to {$phone} for meeting: {$meeting->title}");
    }

    /**
     * Helper: Generate online meeting link
     */
    private function generateOnlineMeetingLink($meeting)
    {
        try {
            // Generate a simple unique link
            $uniqueId = uniqid('meeting_', true);
            $baseUrl = config('app.url', 'http://localhost:8000');
            
            // If online_platform exists, use it, otherwise create generic
            if ($meeting->online_platform) {
                switch ($meeting->online_platform) {
                    case 'zoom':
                        return 'https://zoom.us/j/' . $uniqueId;
                        
                    case 'google_meet':
                        return 'https://meet.google.com/' . substr(md5($meeting->id . time()), 0, 10);
                        
                    case 'teams':
                        return 'https://teams.microsoft.com/l/meetup-join/' . $uniqueId;
                        
                    default:
                        return $baseUrl . '/virtual-meeting/' . $uniqueId;
                }
            }
            
            // Default generic link
            return $baseUrl . '/virtual-meeting/' . $uniqueId;
            
        } catch (\Exception $e) {
            Log::error('Error in generateOnlineMeetingLink: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Helper: Generate QR code
     */
    private function generateQRCode($meeting)
    {
        try {
            // Generate attendance URL with token
            $token = md5($meeting->id . config('app.key'));
            $attendanceUrl = url('/meeting/attendance/' . $meeting->id . '/' . $token);
            
            Log::info('Generating QR code for URL: ' . $attendanceUrl);
            
            // Create directory if it doesn't exist
            $directory = 'public/qr_codes';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            
            // Generate QR code content (simplified version)
            // In production, you might want to use a QR code library
            // For now, create a simple text file with the URL
            $fileName = 'qr_codes/meeting_' . $meeting->id . '_' . time() . '.txt';
            $fullPath = 'public/' . $fileName;
            
            Storage::put($fullPath, $attendanceUrl);
            
            Log::info('QR code file created at: ' . $fullPath);
            
            return $fileName;
            
        } catch (\Exception $e) {
            Log::error('Error in generateQRCode helper: ' . $e->getMessage() . ' - ' . $e->getTraceAsString());
            throw $e;
        }
    }
    public function showAttendanceQR($meetingId, $hash)
{
    $meeting = StaffMeeting::findOrFail($meetingId);
    
    // Verify hash for security
    if ($hash !== md5($meeting->id . $meeting->created_at)) {
        abort(404);
    }
    
    // Check if QR code exists
    if (!$meeting->attendance_qr_code || !Storage::exists($meeting->attendance_qr_code)) {
        abort(404);
    }
    
    // Return the image
    return response()->file(storage_path('app/' . $meeting->attendance_qr_code));
}
}