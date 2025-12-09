<?php

namespace App\Http\Controllers;

use App\Models\StaffMeeting;
use App\Models\Admin;
use App\Http\Requests\StoreStaffMeetingRequest;
use App\Http\Requests\UpdateStaffMeetingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class StaffMeetingController extends Controller
{
    // Add these properties at the top
    private $categories = [
        'management' => 'Management',
        'departmental' => 'Departmental',
        'training' => 'Training',
        'hr_policy_compliance' => 'HR Policy/Compliance',
        'client_review' => 'Client Review',
        'project_review' => 'Project Review',
        'weekly_coordination' => 'Weekly Coordination',
        'emergency_meeting' => 'Emergency Meeting',
    ];
    
    private $platforms = [
        'office' => 'Office',
        'online' => 'Online',
        'client_office' => 'Client Office',
        'training_center' => 'Training Center',
    ];
    
    private $departments = ['HR', 'IT', 'Sales', 'Marketing', 'Finance', 'Operations', 'Admin'];

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = StaffMeeting::with(['admin', 'leader', 'organizer']);
        
        // Apply filters if they exist
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }
        
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }
        
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        
        if ($request->filled('organizer')) {
            $query->where('organizer_id', $request->organizer);
        }
        
        if ($request->filled('meeting_type')) {
            $query->where('type', $request->meeting_type);
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('agenda', 'LIKE', "%{$search}%")
                  ->orWhere('department', 'LIKE', "%{$search}%");
            });
        }
        
        $meetings = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(20);
        
        $stats = $this->getMeetingStats();
        
        // Add this line - get all admins for the organizer filter dropdown
        $admins = Admin::all();
        
        return view('admin.pages.staff-meetings.index', compact('meetings', 'stats', 'admins'))
            ->with('categories', $this->categories)
            ->with('platforms', $this->platforms)
            ->with('departments', $this->departments);
    }

    /**
     * Display calendar view.
     */
    public function calendar()
    {
        $admins = Admin::all(); // Get admins for filter dropdown
        
        return view('admin.pages.staff-meetings.calendar')
            ->with('categories', $this->categories)
            ->with('platforms', $this->platforms)
            ->with('departments', $this->departments)
            ->with('admins', $admins);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admins = Admin::all();
        
        return view('admin.pages.staff-meetings.create', compact('admins'))
            ->with('categories', $this->categories)
            ->with('platforms', $this->platforms)
            ->with('departments', $this->departments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            
            // Combine date with start_time and end_time
            $data['start_time'] = $data['date'] . ' ' . $data['start_time'] . ':00';
            $data['end_time'] = $data['date'] . ' ' . $data['end_time'] . ':00';
            
            // Handle participants
            if ($request->has('participants')) {
                $data['participants'] = json_encode($request->participants);
            } else {
                $data['participants'] = json_encode([]);
            }
            
            // Handle attachments
            if ($request->hasFile('attachments')) {
                $attachments = [];
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('meetings/attachments', 'public');
                    $attachments[] = [
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'size' => $file->getSize(),
                    ];
                }
                $data['attachments'] = json_encode($attachments);
            }
            
            StaffMeeting::create($data);
            
            return redirect()->route('admin.staff-meetings.index')
                ->with('success', 'Meeting scheduled successfully.');
                
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StaffMeeting $staffMeeting)
    {
        $staffMeeting->load(['admin', 'leader', 'organizer']);
        
        // Get participants details
        $participants = [];
        
        // Safely decode participants JSON
        if ($staffMeeting->participants) {
            $participantIds = json_decode($staffMeeting->participants, true);
            
            if (is_array($participantIds) && count($participantIds) > 0) {
                $participants = Admin::whereIn('id', $participantIds)->get();
            }
        }
        
        return view('admin.pages.staff-meetings.show', compact('staffMeeting', 'participants'))
            ->with('categories', $this->categories)
            ->with('platforms', $this->platforms);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffMeeting $staffMeeting)
    {
        $admins = Admin::all();
        
        // Format times for form input
        $staffMeeting->form_start_time = $staffMeeting->start_time ? $staffMeeting->start_time->format('H:i') : '';
        $staffMeeting->form_end_time = $staffMeeting->end_time ? $staffMeeting->end_time->format('H:i') : '';
        
        return view('admin.pages.staff-meetings.edit', compact('staffMeeting', 'admins'))
            ->with('categories', $this->categories)
            ->with('platforms', $this->platforms)
            ->with('departments', $this->departments);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStaffMeetingRequest $request, StaffMeeting $staffMeeting)
    {
        $data = $request->validated();
        
        // Combine date with start_time and end_time
        $data['start_time'] = $data['date'] . ' ' . $data['start_time'] . ':00';
        $data['end_time'] = $data['date'] . ' ' . $data['end_time'] . ':00';
        
        // Handle participants
        if ($request->has('participants')) {
            $data['participants'] = json_encode($request->participants);
        }
        
        // Handle new attachments
        if ($request->hasFile('attachments')) {
            $existingAttachments = $staffMeeting->attachments ?? [];
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('meetings/attachments', 'public');
                $existingAttachments[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                ];
            }
            $data['attachments'] = json_encode($existingAttachments);
        }
        
        $staffMeeting->update($data);
        
        return redirect()->route('admin.staff-meetings.show', $staffMeeting)
            ->with('success', 'Meeting updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffMeeting $staffMeeting)
    {
        // Delete attachments
        if ($staffMeeting->attachments) {
            foreach ($staffMeeting->attachments as $attachment) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }
        
        $staffMeeting->delete();
        
        return redirect()->route('admin.staff-meetings.index')
            ->with('success', 'Meeting deleted successfully.');
    }

    /**
     * Update meeting status.
     */
    public function updateStatus(Request $request, StaffMeeting $staffMeeting)
    {
        $request->validate([
            'status' => 'required|in:scheduled,rescheduled,cancelled,completed',
        ]);
        
        $staffMeeting->update(['status' => $request->status]);
        
        return back()->with('success', 'Meeting status updated successfully.');
    }

    /**
     * Get calendar data for AJAX requests.
     */
    public function calendarData(Request $request)
    {
        // Debug: Check what's being requested
        Log::info('Calendar Data Request:', $request->all());
        
        $query = StaffMeeting::with(['organizer'])
            ->where('status', '!=', 'cancelled');
        
        // Debug: Check total meetings
        $totalMeetings = StaffMeeting::count();
        Log::info('Total meetings in database: ' . $totalMeetings);
        
        // Apply filters if provided
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        
        if ($request->filled('organizer')) {
            $query->where('organizer_id', $request->organizer);
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('date', [$request->start_date, $request->end_date]);
        } else {
            // Default to current month if no date range provided
            $currentMonth = date('m');
            $currentYear = date('Y');
            $query->whereMonth('date', $currentMonth)
                  ->whereYear('date', $currentYear);
        }
        
        // Debug: Check the SQL query
        Log::info('Calendar Query: ' . $query->toSql());
        
        $meetings = $query->get();
        
        // Debug: Check how many meetings were found
        Log::info('Meetings found: ' . $meetings->count());
        
        $formattedMeetings = $meetings->map(function($meeting) {
            // Debug each meeting
            Log::info('Meeting found:', [
                'id' => $meeting->id,
                'title' => $meeting->title,
                'date' => $meeting->date,
                'start_time' => $meeting->start_time,
                'status' => $meeting->status
            ]);
            
            return [
                'id' => $meeting->id,
                'title' => $meeting->title . ' - ' . ($meeting->department ?? 'General'),
                'start' => $meeting->date->format('Y-m-d') . 'T' . $meeting->start_time->format('H:i:s'),
                'end' => $meeting->date->format('Y-m-d') . 'T' . $meeting->end_time->format('H:i:s'),
                'description' => 
                    'Organizer: ' . ($meeting->organizer->name ?? 'N/A') . '\n' .
                    'Category: ' . ucfirst(str_replace('_', ' ', $meeting->category)) . '\n' .
                    'Type: ' . ucfirst($meeting->type) . '\n' .
                    'Agenda: ' . ($meeting->agenda ?? 'No agenda'),
                'status' => $meeting->status,
                'category' => $meeting->category,
                'department' => $meeting->department,
                'organizer' => $meeting->organizer->name ?? 'N/A',
                'url' => route('admin.staff-meetings.show', $meeting),
                'color' => $this->getEventColor($meeting->status),
                'extendedProps' => [
                    'department' => $meeting->department,
                    'category' => $meeting->category,
                    'status' => $meeting->status,
                    'organizer' => $meeting->organizer->name ?? 'N/A',
                    'description' => $meeting->agenda ?? 'No agenda'
                ]
            ];
        });
        
        // Debug: Check formatted data
        Log::info('Formatted meetings count: ' . $formattedMeetings->count());
        
        return response()->json($formattedMeetings);
    }

    /**
     * Filter meetings by status.
     */
    public function filterByStatus($status)
    {
        $meetings = StaffMeeting::with(['admin', 'leader', 'organizer'])
            ->where('status', $status)
            ->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(20);
        
        $stats = $this->getMeetingStats();
        $admins = Admin::all();
        
        return view('admin.pages.staff-meetings.index', compact('meetings', 'stats', 'admins'))
            ->with('categories', $this->categories)
            ->with('platforms', $this->platforms)
            ->with('departments', $this->departments)
            ->with('currentStatus', $status);
    }

    /**
     * Display upcoming meetings.
     */
    public function upcoming()
    {
        $meetings = StaffMeeting::with(['admin', 'leader', 'organizer'])
            ->where('date', '>=', Carbon::today())
            ->where('status', 'scheduled')
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(20);
        
        $stats = $this->getMeetingStats();
        $admins = Admin::all();
        
        return view('admin.pages.staff-meetings.index', compact('meetings', 'stats', 'admins'))
            ->with('categories', $this->categories)
            ->with('platforms', $this->platforms)
            ->with('departments', $this->departments)
            ->with('title', 'Upcoming Meetings');
    }

    /**
     * Export meetings to CSV.
     */
    public function export(Request $request)
    {
        $meetings = StaffMeeting::with(['admin', 'leader', 'organizer'])
            ->get();
        
        $filename = 'meetings_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($meetings) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID', 'Title', 'Date', 'Start Time', 'End Time', 'Category', 
                'Department', 'Type', 'Platform', 'Status', 'Organizer', 
                'Participants Count', 'Created At'
            ]);
            
            foreach ($meetings as $meeting) {
                fputcsv($file, [
                    $meeting->id,
                    $meeting->title,
                    $meeting->date->format('Y-m-d'),
                    $meeting->start_time->format('H:i'),
                    $meeting->end_time->format('H:i'),
                    $meeting->category,
                    $meeting->department,
                    $meeting->type,
                    $meeting->platform,
                    $meeting->status,
                    $meeting->organizer->name ?? 'N/A',
                    count($meeting->participants ?? []),
                    $meeting->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Filter meetings via AJAX.
     */
    public function filterAjax(Request $request)
    {
        $query = StaffMeeting::with(['admin', 'leader', 'organizer']);
        
        // Apply filters if they exist
        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }
        
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }
        
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }
        
        if ($request->filled('organizer')) {
            $query->where('organizer_id', $request->organizer);
        }
        
        if ($request->filled('meeting_type')) {
            $query->where('type', $request->meeting_type);
        }
        
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('agenda', 'LIKE', "%{$search}%")
                  ->orWhere('department', 'LIKE', "%{$search}%");
            });
        }
        
        $meetings = $query->orderBy('date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(20)
            ->appends($request->except('page'));
        
        // Return partial view for AJAX
        return view('admin.pages.staff-meetings.partials.meetings-table', compact('meetings'));
    }

    /**
     * Get meeting statistics.
     */
    private function getMeetingStats()
    {
        return [
            'total' => StaffMeeting::count(),
            'scheduled' => StaffMeeting::where('status', 'scheduled')->count(),
            'upcoming' => StaffMeeting::where('date', '>=', Carbon::today())
                ->where('status', 'scheduled')->count(),
            'completed' => StaffMeeting::where('status', 'completed')->count(),
            'cancelled' => StaffMeeting::where('status', 'cancelled')->count(),
            'today' => StaffMeeting::whereDate('date', Carbon::today())->count(),
            'this_week' => StaffMeeting::whereBetween('date', 
                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count(),
            'this_month' => StaffMeeting::whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year)->count(),
        ];
    }

    /**
     * Helper method for event colors.
     */
    private function getEventColor($status)
    {
        switch($status) {
            case 'scheduled': return '#28a745'; // Green
            case 'completed': return '#17a2b8'; // Blue
            case 'cancelled': return '#dc3545'; // Red
            case 'rescheduled': return '#ffc107'; // Yellow
            default: return '#007bff'; // Primary blue
        }
    }

    /**
     * Get categories list.
     */
    private function getCategories()
    {
        return $this->categories;
    }

    /**
     * Get platforms list.
     */
    private function getPlatforms()
    {
        return $this->platforms;
    }

    /**
     * Get online platforms list.
     */
    private function getOnlinePlatforms()
    {
        return [
            'zoom' => 'Zoom',
            'google_meet' => 'Google Meet',
            'teams' => 'Microsoft Teams',
        ];
    }
}