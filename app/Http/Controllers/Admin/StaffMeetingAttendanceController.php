<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Models\StaffMeetingAttendance;
use App\Models\StaffMeeting;
use App\Models\Admin; // Correct import for Admin model
use App\Http\Controllers\Controller; 
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\AttendanceRequest;

use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
class StaffMeetingAttendanceController extends Controller
{
// public function index(Request $request)
// {
//     $query = StaffMeetingAttendance::with(['meeting', 'staff', 'approver'])
//         ->latest();

//     // Filters for attendance records
//     if ($request->filled('meeting_id')) {
//         $query->where('meeting_id', $request->meeting_id);
//     }

//     if ($request->filled('staff_id')) {
//         $query->where('staff_id', $request->staff_id);
//     }

//     if ($request->filled('department')) {
//         $query->where('department', $request->department);
//     }

//     if ($request->filled('status')) {
//         $query->where('status', $request->status);
//     }

//     if ($request->filled('date_from')) {
//         $query->whereDate('created_at', '>=', $request->date_from);
//     }

//     if ($request->filled('date_to')) {
//         $query->whereDate('created_at', '<=', $request->date_to);
//     }

//     if ($request->filled('requires_approval')) {
//         $query->where('requires_approval', true);
//     }

//     $attendances = $query->paginate(20);
//     $meetings = StaffMeeting::latest()->get();
    
//     // NEW: Monthly summary logic
//     $summaryView = $request->get('view', 'records'); // Default to records view
    
//     // Initialize monthly summary variables with default values
//     $monthlyData = null; // Initialize as null instead of collection
//     $monthList = [];
//     $years = collect(); // Initialize as empty collection
//     $departmentStats = collect(); // Initialize as empty collection
    
//     // Initialize with integer values
//     $year = (int) date('Y');
//     $monthNum = (int) date('m');
//     $monthlyDepartment = $request->get('monthly_department');
//     $monthlyStaffId = $request->get('monthly_staff_id');
    
//     if ($summaryView === 'monthly') {
//         // Get filter values for monthly summary (use different parameter names to avoid conflict)
//         $year = (int) $request->get('monthly_year', date('Y'));
//         $monthNum = (int) $request->get('monthly_month', date('m')); // Cast to integer
//         $monthlyDepartment = $request->get('monthly_department');
//         $monthlyStaffId = $request->get('monthly_staff_id');
        
//         // Get all months for dropdown
//         for ($i = 1; $i <= 12; $i++) {
//             $monthList[$i] = Carbon::create()->month($i)->format('F');
//         }
        
//         // Get years from attendance records
//         $years = StaffMeetingAttendance::selectRaw('YEAR(created_at) as year')
//             ->groupBy(DB::raw('YEAR(created_at)'))
//             ->orderBy('year', 'desc')
//             ->pluck('year')
//             ->map(function ($year) {
//                 return (int) $year; // Ensure years are integers
//             });
            
//         // Query for monthly summary
//         $monthlyQuery = StaffMeetingAttendance::select(
//                 'staff_id',
//                 'staff_name',
//                 'department',
//                 DB::raw('COUNT(*) as total_meetings'),
//                 DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count'),
//                 DB::raw('SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_count'),
//                 DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count'),
//                 DB::raw('SUM(CASE WHEN status = "on_leave" THEN 1 ELSE 0 END) as leave_count'),
//                 DB::raw('SUM(CASE WHEN status = "work_from_field" THEN 1 ELSE 0 END) as field_count'),
//                 DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_percentage')
//             )
//             ->whereYear('created_at', $year)
//             ->whereMonth('created_at', $monthNum)
//             ->groupBy('staff_id', 'staff_name', 'department');
            
//         // Apply filters for monthly summary
//         if ($monthlyDepartment) {
//             $monthlyQuery->where('department', $monthlyDepartment);
//         }
        
//         if ($monthlyStaffId) {
//             $monthlyQuery->where('staff_id', $monthlyStaffId);
//         }
        
//         $monthlyData = $monthlyQuery->orderBy('attendance_percentage', 'desc')
//             ->paginate(20)
//             ->withQueryString()
//             ->appends([
//                 'view' => 'monthly',
//                 'monthly_year' => $year,
//                 'monthly_month' => $monthNum,
//                 'monthly_department' => $monthlyDepartment,
//                 'monthly_staff_id' => $monthlyStaffId
//             ]);
            
//         // Department statistics
//         $departmentStats = StaffMeetingAttendance::whereYear('created_at', $year)
//             ->whereMonth('created_at', $monthNum)
//             ->select(
//                 'department',
//                 DB::raw('COUNT(*) as total'),
//                 DB::raw('SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) as attended'),
//                 DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as percentage')
//             )
//             ->whereNotNull('department')
//             ->groupBy('department')
//             ->orderBy('percentage', 'desc')
//             ->get();
//     }
    
//     return view('admin.attendance.index', compact(
//         'attendances',
//         'meetings',
//         'summaryView',
//         'monthlyData',
//         'monthList',
//         'years',
//         'departmentStats',
//         'year',
//         'monthNum',
//         'monthlyDepartment',
//         'monthlyStaffId'
//     ));
// }
 public function index(Request $request)
    {
        $query = StaffMeetingAttendance::with(['meeting', 'staff', 'approver'])
            ->latest();

        // Filters for attendance records
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
        
        $summaryView = $request->get('view', 'records');
        
        // Initialize variables
        $monthlyData = null;
        $monthList = [];
        $years = collect();
        $departmentStats = collect();
        $topAttendees = collect();
        $lowAttendees = collect();
        $repeatedAbsences = collect();
        
        $year = (int) date('Y');
        $monthNum = (int) date('m');
        $monthlyDepartment = $request->get('monthly_department');
        $monthlyStaffId = $request->get('monthly_staff_id');
        
        if ($summaryView === 'monthly') {
            $year = (int) $request->get('monthly_year', date('Y'));
            $monthNum = (int) $request->get('monthly_month', date('m'));
            $monthlyDepartment = $request->get('monthly_department');
            $monthlyStaffId = $request->get('monthly_staff_id');
            
            // Get all months for dropdown
            for ($i = 1; $i <= 12; $i++) {
                $monthList[$i] = Carbon::create()->month($i)->format('F');
            }
            
            // Get years from attendance records
            $years = StaffMeetingAttendance::selectRaw('YEAR(created_at) as year')
                ->groupBy(DB::raw('YEAR(created_at)'))
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->map(function ($year) {
                    return (int) $year;
                });
                
            // Query for monthly summary
            $monthlyQuery = StaffMeetingAttendance::select(
                    'staff_id',
                    'staff_name',
                    'department',
                    DB::raw('COUNT(*) as total_meetings'),
                    DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count'),
                    DB::raw('SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_count'),
                    DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count'),
                    DB::raw('SUM(CASE WHEN status = "on_leave" THEN 1 ELSE 0 END) as leave_count'),
                    DB::raw('SUM(CASE WHEN status = "work_from_field" THEN 1 ELSE 0 END) as field_count'),
                    DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_percentage')
                )
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $monthNum)
                ->groupBy('staff_id', 'staff_name', 'department');
                
            // Apply filters for monthly summary
            if ($monthlyDepartment) {
                $monthlyQuery->where('department', $monthlyDepartment);
            }
            
            if ($monthlyStaffId) {
                $monthlyQuery->where('staff_id', $monthlyStaffId);
            }
            
            $monthlyData = $monthlyQuery->orderBy('attendance_percentage', 'desc')
                ->paginate(20)
                ->withQueryString()
                ->appends([
                    'view' => 'monthly',
                    'monthly_year' => $year,
                    'monthly_month' => $monthNum,
                    'monthly_department' => $monthlyDepartment,
                    'monthly_staff_id' => $monthlyStaffId
                ]);
                
            // Department statistics
            $departmentStats = StaffMeetingAttendance::whereYear('created_at', $year)
                ->whereMonth('created_at', $monthNum)
                ->select(
                    'department',
                    DB::raw('COUNT(*) as total'),
                    DB::raw('SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) as attended'),
                    DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as percentage')
                )
                ->whereNotNull('department')
                ->groupBy('department')
                ->orderBy('percentage', 'desc')
                ->get();
            
            // Get top attendees (attendance >= 90%)
            $topAttendees = StaffMeetingAttendance::select(
                    'staff_id',
                    'staff_name',
                    'department',
                    DB::raw('COUNT(*) as total_meetings'),
                    DB::raw('SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) as attended_count'),
                    DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_percentage')
                )
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $monthNum)
                ->groupBy('staff_id', 'staff_name', 'department')
                ->having('attendance_percentage', '>=', 90)
                ->orderBy('attendance_percentage', 'desc')
                ->limit(10)
                ->get();
            
            // Get low attendees (attendance < 70%)
            $lowAttendees = StaffMeetingAttendance::select(
                    'staff_id',
                    'staff_name',
                    'department',
                    DB::raw('COUNT(*) as total_meetings'),
                    DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count'),
                    DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_percentage')
                )
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $monthNum)
                ->groupBy('staff_id', 'staff_name', 'department')
                ->having('attendance_percentage', '<', 70)
                ->having('total_meetings', '>=', 3) // Only show if attended at least 3 meetings
                ->orderBy('attendance_percentage', 'asc')
                ->limit(10)
                ->get();
            
            // Get repeated absences (3 or more consecutive absences)
            $repeatedAbsences = $this->getRepeatedAbsences($year, $monthNum, $monthlyDepartment);
        }
        
        return view('admin.attendance.index', compact(
            'attendances',
            'meetings',
            'summaryView',
            'monthlyData',
            'monthList',
            'years',
            'departmentStats',
            'year',
            'monthNum',
            'monthlyDepartment',
            'monthlyStaffId',
            'topAttendees',
            'lowAttendees',
            'repeatedAbsences'
        ));
    }
     // Helper method to find repeated absences
    private function getRepeatedAbsences($year, $month, $department = null)
    {
        // Get all staff with their attendance records for the month
        $query = StaffMeetingAttendance::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('staff_id')
            ->orderBy('created_at');
            
        if ($department) {
            $query->where('department', $department);
        }
        
        $attendanceRecords = $query->get();
        
        $repeatedAbsences = collect();
        $consecutiveAbsences = [];
        
        foreach ($attendanceRecords as $record) {
            $staffId = $record->staff_id;
            
            if (!isset($consecutiveAbsences[$staffId])) {
                $consecutiveAbsences[$staffId] = [
                    'count' => 0,
                    'records' => [],
                    'staff_name' => $record->staff_name,
                    'department' => $record->department
                ];
            }
            
            if ($record->status === 'absent') {
                $consecutiveAbsences[$staffId]['count']++;
                $consecutiveAbsences[$staffId]['records'][] = $record;
                
                // Check if we have 3 or more consecutive absences
                if ($consecutiveAbsences[$staffId]['count'] >= 3) {
                    if (!$repeatedAbsences->has($staffId)) {
                        $repeatedAbsences->put($staffId, [
                            'staff_id' => $staffId,
                            'staff_name' => $record->staff_name,
                            'department' => $record->department,
                            'consecutive_absences' => $consecutiveAbsences[$staffId]['count'],
                            'last_absence_date' => $record->created_at->format('Y-m-d'),
                            'records' => $consecutiveAbsences[$staffId]['records']
                        ]);
                    }
                }
            } else {
                // Reset counter if not absent
                $consecutiveAbsences[$staffId]['count'] = 0;
                $consecutiveAbsences[$staffId]['records'] = [];
            }
        }
        
        return $repeatedAbsences->values();
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
public function staffDetail($staff, Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        
        // Get staff details
        $staffMember = Admin::findOrFail($staff);
        
        // Get attendance records for the selected month
        $attendances = StaffMeetingAttendance::with('meeting')
            ->where('staff_id', $staff)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Calculate statistics
        $totalMeetings = $attendances->count();
        $presentCount = $attendances->where('status', 'present')->count();
        $lateCount = $attendances->where('status', 'late')->count();
        $absentCount = $attendances->where('status', 'absent')->count();
        $leaveCount = $attendances->where('status', 'on_leave')->count();
        $fieldCount = $attendances->where('status', 'work_from_field')->count();
        
        $attendancePercentage = $totalMeetings > 0 
            ? round((($presentCount + $lateCount) / $totalMeetings) * 100, 2) 
            : 0;
            
        // Get months and years for dropdown
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create()->month($i)->format('F');
        }
        
        $years = StaffMeetingAttendance::selectRaw('YEAR(created_at) as year')
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderBy('year', 'desc')
            ->pluck('year');
            
        return view('admin.attendance.staff-detail', compact(
            'staffMember',
            'attendances',
            'totalMeetings',
            'presentCount',
            'lateCount',
            'absentCount',
            'leaveCount',
            'fieldCount',
            'attendancePercentage',
            'year',
            'month',
            'months',
            'years'
        ));
    }

    public function exportStaffReport($staff, Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        
        // Get staff details
        $staffMember = Admin::findOrFail($staff);
        
        // Get attendance records for the selected month
        $attendances = StaffMeetingAttendance::with('meeting')
            ->where('staff_id', $staff)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Calculate statistics
        $totalMeetings = $attendances->count();
        $presentCount = $attendances->where('status', 'present')->count();
        $lateCount = $attendances->where('status', 'late')->count();
        $absentCount = $attendances->where('status', 'absent')->count();
        $leaveCount = $attendances->where('status', 'on_leave')->count();
        $fieldCount = $attendances->where('status', 'work_from_field')->count();
        
        $attendancePercentage = $totalMeetings > 0 
            ? round((($presentCount + $lateCount) / $totalMeetings) * 100, 2) 
            : 0;
            
        $monthName = Carbon::create()->month($month)->format('F');
        
        $data = [
            'staffMember' => $staffMember,
            'attendances' => $attendances,
            'totalMeetings' => $totalMeetings,
            'presentCount' => $presentCount,
            'lateCount' => $lateCount,
            'absentCount' => $absentCount,
            'leaveCount' => $leaveCount,
            'fieldCount' => $fieldCount,
            'attendancePercentage' => $attendancePercentage,
            'year' => $year,
            'month' => $monthName,
            'reportDate' => now()->format('F d, Y'),
            'companyName' => config('app.name', 'TechFocus'),
        ];
        
        $pdf = PDF::loadView('admin.attendance.pdf.staff-report', $data);
        
        $fileName = "attendance-report-{$staffMember->name}-{$monthName}-{$year}.pdf";
        
        return $pdf->download($fileName);
    }

    public function exportMonthlySummary(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        $department = $request->get('department');
        
        // Get monthly summary data
        $query = StaffMeetingAttendance::select(
                'staff_id',
                'staff_name',
                'department',
                DB::raw('COUNT(*) as total_meetings'),
                DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count'),
                DB::raw('SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_count'),
                DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count'),
                DB::raw('SUM(CASE WHEN status = "on_leave" THEN 1 ELSE 0 END) as leave_count'),
                DB::raw('SUM(CASE WHEN status = "work_from_field" THEN 1 ELSE 0 END) as field_count'),
                DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_percentage')
            )
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('staff_id', 'staff_name', 'department');
            
        if ($department) {
            $query->where('department', $department);
        }
        
        $summary = $query->orderBy('attendance_percentage', 'desc')->get();
        
        // Department statistics
        $departmentStats = StaffMeetingAttendance::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->select(
                'department',
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) as attended'),
                DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as percentage')
            )
            ->whereNotNull('department')
            ->groupBy('department')
            ->orderBy('percentage', 'desc')
            ->get();
            
        $monthName = Carbon::create()->month($month)->format('F');
        
        $data = [
            'summary' => $summary,
            'departmentStats' => $departmentStats,
            'year' => $year,
            'month' => $monthName,
            'department' => $department,
            'reportDate' => now()->format('F d, Y'),
            'companyName' => config('app.name', 'TechFocus'),
        ];
        
        $pdf = PDF::loadView('admin.attendance.pdf.monthly-summary', $data);
        
        $fileName = "monthly-attendance-summary-{$monthName}-{$year}" . ($department ? "-{$department}" : "") . ".pdf";
        
        return $pdf->download($fileName);
    }

    // public function markAttendance()
    // {
    //     // Check if admin is authenticated
    //     if (!auth('admin')->check()) {
    //         return redirect()->route('admin.login')->with('error', 'Please login first');
    //     }
        
    //     // Get upcoming meetings
    //     $meetings = StaffMeeting::where('date', '>=', now()->subDays(7))
    //         ->orderBy('date', 'desc')
    //         ->get();
            
    //     return view('admin.attendance.mark', compact('meetings'));
    // }
    
    /**
     * Submit attendance request
     */

    /**
 * Show approval queue
 */
public function approvalQueue()
{
    $pendingRequests = \App\Models\AttendanceRequest::with(['meeting', 'staff'])
        ->where('status', 'pending')
        ->orderBy('requested_at', 'asc')
        ->paginate(20);
    
    $approvedToday = \App\Models\AttendanceRequest::where('status', 'approved')
        ->whereDate('approved_at', now()->toDateString())
        ->count();
    
    $rejectedToday = \App\Models\AttendanceRequest::where('status', 'rejected')
        ->whereDate('approved_at', now()->toDateString())
        ->count();
    
    return view('admin.attendance.approval-queue', compact(
        'pendingRequests', 
        'approvedToday', 
        'rejectedToday'
    ));
}

/**
 * Approve a single request
 */
public function approveRequest($id, Request $request)
{
    DB::beginTransaction();
    
    try {
        $attendanceRequest = AttendanceRequest::findOrFail($id);
        $meeting = StaffMeeting::find($attendanceRequest->meeting_id);
        
        // Calculate what join_time should be
        $joinTime = null;
        
        // Option 1: Use meeting start time if available
        if ($meeting && $meeting->date && $meeting->time) {
            $joinTime = Carbon::parse($meeting->date . ' ' . $meeting->time);
        } 
        // Option 2: Use requested time (when button was clicked)
        else if ($attendanceRequest->requested_at) {
            $joinTime = $attendanceRequest->requested_at;
        }
        // Option 3: Use current time
        else {
            $joinTime = now();
        }
        
        // Update the request status
        $attendanceRequest->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', '')
        ]);
        
        // Update or create the attendance record
        $attendance = StaffMeetingAttendance::updateOrCreate(
            [
                'meeting_id' => $attendanceRequest->meeting_id,
                'staff_id' => $attendanceRequest->staff_id
            ],
            [
                'staff_name' => $attendanceRequest->staff->name,
                'department' => $attendanceRequest->staff->department,
                'status' => 'present',
                'requested_at' => $attendanceRequest->requested_at,
                'join_time' => $joinTime, // Set the correct join time
                'meeting_start_time' => $meeting && $meeting->date && $meeting->time 
                    ? Carbon::parse($meeting->date . ' ' . $meeting->time) 
                    : null,
                'actual_join_time' => $attendanceRequest->requested_at, // When they actually clicked
                'requires_approval' => false,
                'is_approved' => true,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'notes' => 'Approved by admin'
            ]
        );
        
        DB::commit();
        
        return response()->json([
            'success' => true, 
            'message' => 'Attendance approved successfully!'
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false, 
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Reject a single request
 */
public function rejectRequest($id, Request $request)
{
    try {
        $attendanceRequest = \App\Models\AttendanceRequest::findOrFail($id);
        
        $attendanceRequest->update([
            'status' => 'rejected',
            'approved_by' => auth('admin')->id(),
            'approved_at' => now(),
            'admin_notes' => $request->input('notes', 'Rejected by admin')
        ]);
        
        // Optionally update attendance record
        \App\Models\StaffMeetingAttendance::where('meeting_id', $attendanceRequest->meeting_id)
            ->where('staff_id', $attendanceRequest->staff_id)
            ->update([
                'status' => 'absent',
                'is_approved' => false,
                'notes' => 'Request rejected: ' . $request->input('notes', '')
            ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Attendance request rejected.'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Bulk approve requests
 */
public function bulkApprove(Request $request)
{
    try {
        $validated = $request->validate([
            'request_ids' => 'required|array',
            'request_ids.*' => 'exists:attendance_requests,id',
            'notes' => 'nullable|string',
            'send_notification' => 'boolean'
        ]);
        
        DB::beginTransaction();
        
        $approvedCount = 0;
        
        foreach ($validated['request_ids'] as $requestId) {
            $attendanceRequest = \App\Models\AttendanceRequest::find($requestId);
            
            if ($attendanceRequest && $attendanceRequest->status === 'pending') {
                $attendanceRequest->update([
                    'status' => 'approved',
                    'approved_by' => auth('admin')->id(),
                    'approved_at' => now(),
                    'admin_notes' => $validated['notes'] ?? 'Bulk approved by admin'
                ]);
                
                // Update attendance record
                \App\Models\StaffMeetingAttendance::where('meeting_id', $attendanceRequest->meeting_id)
                    ->where('staff_id', $attendanceRequest->staff_id)
                    ->update([
                        'status' => 'present',
                        'requires_approval' => false,
                        'is_approved' => true,
                        'approved_by' => auth('admin')->id(),
                        'approved_at' => now(),
                        'notes' => 'Bulk approved via admin panel'
                    ]);
                
                $approvedCount++;
            }
        }
        
        DB::commit();
        
        return response()->json([
            'success' => true,
            'message' => "Successfully approved {$approvedCount} requests.",
            'processed' => $approvedCount
        ]);
        
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Bulk reject requests
 */
public function bulkReject(Request $request)
{
    try {
        $validated = $request->validate([
            'request_ids' => 'required|array',
            'request_ids.*' => 'exists:attendance_requests,id',
            'notes' => 'required|string',
            'send_notification' => 'boolean'
        ]);
        
        $rejectedCount = 0;
        
        foreach ($validated['request_ids'] as $requestId) {
            $attendanceRequest = \App\Models\AttendanceRequest::find($requestId);
            
            if ($attendanceRequest && $attendanceRequest->status === 'pending') {
                $attendanceRequest->update([
                    'status' => 'rejected',
                    'approved_by' => auth('admin')->id(),
                    'approved_at' => now(),
                    'admin_notes' => $validated['notes'] ?? 'Bulk rejected by admin'
                ]);
                
                $rejectedCount++;
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => "Successfully rejected {$rejectedCount} requests.",
            'processed' => $rejectedCount
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Get request details
 */
public function requestDetails($id)
{
    try {
        $request = \App\Models\AttendanceRequest::with(['meeting', 'staff', 'approver'])
            ->findOrFail($id);
        
        return view('admin.attendance.partials.request-details', compact('request'));
        
    } catch (\Exception $e) {
        return '<div class="alert alert-danger">Error loading request details</div>';
    }
}
    // public function submitRequest(Request $request)
    // {
    //     // Use admin guard
    //     if (!auth('admin')->check()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Admin not authenticated. Please login.'
    //         ], 401);
    //     }
        
    //     try {
    //         $validated = $request->validate([
    //             'meeting_id' => 'required|exists:staff_meetings,id',
    //             'staff_id' => 'required|exists:admins,id'
    //         ]);
            
    //         // Verify the staff_id matches the logged-in admin
    //         $adminId = auth('admin')->id();
    //         if ($validated['staff_id'] != $adminId) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Unauthorized: Staff ID does not match logged-in admin.'
    //             ], 403);
    //         }
            
    //         // Get admin details
    //         $admin = Admin::findOrFail($adminId);
            
    //         // Check for duplicate pending request
    //         $existing = AttendanceRequest::where('meeting_id', $validated['meeting_id'])
    //             ->where('staff_id', $adminId)
    //             ->where('status', 'pending')
    //             ->first();
                
    //         if ($existing) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'You already have a pending request for this meeting.'
    //             ], 422);
    //         }
            
    //         // Check if already attended
    //         $alreadyAttended = StaffMeetingAttendance::where('meeting_id', $validated['meeting_id'])
    //             ->where('staff_id', $adminId)
    //             ->exists();
                
    //         if ($alreadyAttended) {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'You have already attended this meeting.'
    //             ], 422);
    //         }
            
    //         // Create attendance request
    //         AttendanceRequest::create([
    //             'meeting_id' => $validated['meeting_id'],
    //             'staff_id' => $adminId,
    //             'status' => 'pending',
    //             'requested_at' => now()
    //         ]);
            
    //         // Create pending attendance record
    //         StaffMeetingAttendance::create([
    //             'meeting_id' => $validated['meeting_id'],
    //             'staff_id' => $adminId,
    //             'staff_name' => $admin->name,
    //             'department' => is_array($admin->department) ? implode(', ', $admin->department) : $admin->department,
    //             'status' => 'absent', // Default until approved
    //             'requires_approval' => true,
    //             'is_approved' => false,
    //             'join_time' => now(),
    //             'notes' => 'Pending approval - submitted via button'
    //         ]);
            
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Attendance request submitted successfully! Waiting for approval.'
    //         ]);
            
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Error: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }
public function submitRequest(Request $request)
{
    try {
        $validated = $request->validate([
            'meeting_id' => 'required|exists:staff_meetings,id',
            'staff_id' => 'required|exists:admins,id'
        ]);
        
        // Get staff details
        $staff = Admin::findOrFail($validated['staff_id']);
        $meeting = StaffMeeting::findOrFail($validated['meeting_id']);
        
        // Check for existing attendance request
        $existingRequest = AttendanceRequest::where('meeting_id', $validated['meeting_id'])
            ->where('staff_id', $validated['staff_id'])
            ->first();
        
        // Check for existing attendance record
        $existingAttendance = StaffMeetingAttendance::where('meeting_id', $validated['meeting_id'])
            ->where('staff_id', $validated['staff_id'])
            ->first();
        
        // If already approved
        if ($existingRequest && $existingRequest->status === 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Your attendance for this meeting has already been approved!',
                'type' => 'already_approved',
                'attendance' => $existingAttendance
            ], 422);
        }
        
        // If pending request exists
        if ($existingRequest && $existingRequest->status === 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'You already have a pending attendance request for this meeting!',
                'type' => 'pending_exists',
                'request' => $existingRequest
            ], 422);
        }
        
        // If rejected request exists
        if ($existingRequest && $existingRequest->status === 'rejected') {
            return response()->json([
                'success' => false,
                'message' => 'Your previous attendance request was rejected. Please contact admin.',
                'type' => 'rejected_exists'
            ], 422);
        }
        
        // If attendance already marked (even without request)
        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'Your attendance for this meeting has already been recorded!',
                'type' => 'attendance_exists',
                'attendance' => $existingAttendance
            ], 422);
        }
        
        // Create attendance request
        $attendanceRequest = AttendanceRequest::create([
            'meeting_id' => $validated['meeting_id'],
            'staff_id' => $validated['staff_id'],
            'status' => 'pending',
            'requested_at' => now()
        ]);
        
        // Create pending attendance record
        StaffMeetingAttendance::create([
            'meeting_id' => $validated['meeting_id'],
            'staff_id' => $validated['staff_id'],
            'staff_name' => $staff->name,
            'department' => $staff->department,
            'status' => 'absent', // Default until approved
            'requested_at' => now(),
            'join_time' => $meeting->date && $meeting->time 
                ? Carbon::parse($meeting->date . ' ' . $meeting->time)
                : now(),
            'meeting_start_time' => $meeting->date && $meeting->time 
                ? Carbon::parse($meeting->date . ' ' . $meeting->time)
                : null,
            'requires_approval' => true,
            'is_approved' => false,
            'notes' => 'Pending admin approval'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Attendance request submitted successfully! Waiting for approval.',
            'type' => 'submitted'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
            'type' => 'error'
        ], 500);
    }
}
    /**
     * Get admin's pending requests
     */
    public function myRequests()
    {
        // Use admin guard
        if (!auth('admin')->check()) {
            return response()->json([], 401);
        }
        
        $adminId = auth('admin')->id();
        
        $requests = AttendanceRequest::with('meeting')
            ->where('staff_id', $adminId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($requests);
    }

}