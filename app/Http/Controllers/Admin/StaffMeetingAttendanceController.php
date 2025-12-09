<?php

namespace App\Http\Controllers\Admin;

use App\Models\StaffMeetingAttendance;
use App\Models\StaffMeeting;
use App\Models\Admin; // Correct import for Admin model
use App\Http\Controllers\Controller; 
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StaffMeetingAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffMeetingAttendance::with(['meeting', 'staff', 'approver'])
            ->latest();

        // Filters
        if ($request->filled('meeting_id')) {
            $query->where('meeting_id', $request->meeting_id);
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('requires_approval')) {
            $query->where('requires_approval', true);
        }

        $attendances = $query->paginate(20);
        $meetings = StaffMeeting::latest()->get();
        
        return view('admin.attendance.index', compact('attendances', 'meetings'));
    }

    public function create()
    {
        $meetings = StaffMeeting::where('date', '>=', now()->subDays(7))
            ->orderBy('date', 'desc')
            ->get();
        
        return view('admin.attendance.create', compact('meetings'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        $meeting = StaffMeeting::findOrFail($request->meeting_id);
        $staff = Admin::findOrFail($request->staff_id);
        
        // Check if already marked attendance
        $existing = StaffMeetingAttendance::where('meeting_id', $request->meeting_id)
            ->where('staff_id', $request->staff_id)
            ->first();
            
        if ($existing) {
            return redirect()->back()->with('error', 'Attendance already marked for this staff member.');
        }

        // Auto-detect late status
        $status = $request->status;
        if ($status === 'present') {
            $meetingStart = $meeting->date->copy()->setTimeFrom($meeting->start_time);
            $joinTime = $request->join_time ? Carbon::parse($request->join_time) : now();
            
            if ($joinTime->gt($meetingStart->addMinutes(15))) {
                $status = 'late';
            }
        }

        $attendance = StaffMeetingAttendance::create([
            'meeting_id' => $request->meeting_id,
            'staff_id' => $request->staff_id,
            'staff_name' => $staff->name,
            'department' => $staff->department ?? $request->department,
            'status' => $status,
            'join_time' => $request->join_time ?? now(),
            'leave_time' => $request->leave_time,
            'notes' => $request->notes,
            'device_ip' => $request->ip(),
            'device_agent' => $request->userAgent(),
            'requires_approval' => $request->has('manual_time') || $request->status === 'late',
        ]);

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance marked successfully.');
    }

    public function show(StaffMeetingAttendance $attendance)
    {
        return view('admin.attendance.show', compact('attendance'));
    }

    public function edit(StaffMeetingAttendance $attendance)
    {
        return view('admin.attendance.edit', compact('attendance'));
    }

    public function update(UpdateAttendanceRequest $request, StaffMeetingAttendance $attendance)
    {
        $attendance->update([
            'status' => $request->status ?? $attendance->status,
            'join_time' => $request->join_time ?? $attendance->join_time,
            'leave_time' => $request->leave_time,
            'notes' => $request->notes,
            'requires_approval' => $request->has('requires_approval') ? true : $attendance->requires_approval,
        ]);

        if ($request->has('is_approved') && Auth::user()->hasRole(['hr', 'management'])) {
            $attendance->update([
                'is_approved' => true,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);
        }

        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance updated successfully.');
    }

    public function destroy(StaffMeetingAttendance $attendance)
    {
        $attendance->delete();
        
        return redirect()->route('admin.attendance.index')
            ->with('success', 'Attendance record deleted successfully.');
    }

    public function markViaQR($meetingId, $hash)
    {
        $meeting = StaffMeeting::findOrFail($meetingId);
        
        // Verify hash (you can use the same hash logic from before)
        if ($hash !== md5($meeting->id . $meeting->created_at)) {
            abort(404);
        }
        
        // Get current user
        $staff = Auth::user();
        
        // Check if already marked
        $existing = StaffMeetingAttendance::where('meeting_id', $meetingId)
            ->where('staff_id', $staff->id)
            ->first();
            
        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Attendance already marked.'
            ]);
        }
        
        // Determine status
        $status = 'present';
        $meetingStart = $meeting->date->copy()->setTimeFrom($meeting->start_time);
        $now = now();
        
        if ($now->gt($meetingStart->addMinutes(15))) {
            $status = 'late';
        }
        
        // Create attendance record
        $attendance = StaffMeetingAttendance::create([
            'meeting_id' => $meetingId,
            'staff_id' => $staff->id,
            'staff_name' => $staff->name,
            'department' => $staff->department,
            'status' => $status,
            'join_time' => $now,
            'device_ip' => request()->ip(),
            'device_agent' => request()->userAgent(),
            'requires_approval' => $status === 'late',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Attendance marked successfully.',
            'status' => $status,
            'join_time' => $attendance->join_time->format('h:i A')
        ]);
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'attendances' => 'required|array',
            'attendances.*.id' => 'required|exists:staff_meeting_attendance,id',
            'attendances.*.status' => 'required|in:present,late,absent,on_leave,work_from_field',
        ]);
        
        foreach ($request->attendances as $attendanceData) {
            $attendance = StaffMeetingAttendance::find($attendanceData['id']);
            $attendance->update([
                'status' => $attendanceData['status'],
                'requires_approval' => true,
                'is_approved' => false,
                'approved_by' => null,
                'approved_at' => null,
            ]);
        }
        
        return response()->json(['success' => true, 'message' => 'Attendance updated successfully.']);
    }

    public function approveAttendance(StaffMeetingAttendance $attendance)
    {
        if (!Auth::user()->hasRole(['hr', 'management', 'supervisor'])) {
            abort(403, 'Unauthorized action.');
        }
        
        $attendance->update([
            'is_approved' => true,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Attendance approved successfully.');
    }
}