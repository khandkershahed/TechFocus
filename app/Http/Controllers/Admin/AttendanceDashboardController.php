<?php


namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\StaffMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; 
use App\Models\StaffMeetingAttendance;

class AttendanceDashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $today = now()->toDateString();
        $date = $request->get('date', $today);
        
        // Total staff count
           $totalStaff = Admin::count();
        
        // Today's stats
        $todayAttendances = StaffMeetingAttendance::whereDate('created_at', $date)
            ->with('meeting');
            
        $presentToday = (clone $todayAttendances)->where('status', 'present')->count();
        $absentToday = (clone $todayAttendances)->where('status', 'absent')->count();
        $lateToday = (clone $todayAttendances)->where('status', 'late')->count();
        
        // Meeting attendance percentage
        $todayMeetings = StaffMeeting::whereDate('date', $date)->get();
        $meetingStats = [];
        
        foreach ($todayMeetings as $meeting) {
            $totalParticipants = count(json_decode($meeting->participants, true) ?? []);
            $presentCount = $meeting->presentAttendances()->count();
            $percentage = $totalParticipants > 0 ? round(($presentCount / $totalParticipants) * 100, 2) : 0;
            
            $meetingStats[] = [
                'meeting' => $meeting,
                'percentage' => $percentage,
                'present' => $presentCount,
                'total' => $totalParticipants
            ];
        }
        
        // Department stats
        $departmentStats = StaffMeetingAttendance::whereDate('created_at', $date)
            ->selectRaw('department, 
                COUNT(*) as total, 
                SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present,
                SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late,
                SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent')
            ->whereNotNull('department')
            ->groupBy('department')
            ->get()
            ->map(function($item) {
                $item->percentage = $item->total > 0 ? round(($item->present / $item->total) * 100, 2) : 0;
                return $item;
            });
        
        // Recent attendance
        $recentAttendances = StaffMeetingAttendance::with(['meeting', 'staff'])
            ->latest()
            ->limit(10)
            ->get();
        
        return view('admin.attendance.dashboard', compact(
            'totalStaff',
            'presentToday',
            'absentToday',
            'lateToday',
            'meetingStats',
            'departmentStats',
            'recentAttendances',
            'date'
        ));
    }
    
    public function export(Request $request)
    {
        $query = StaffMeetingAttendance::with(['meeting', 'staff', 'approver'])
            ->latest();
            
        // Apply filters same as index
        if ($request->filled('meeting_id')) {
            $query->where('meeting_id', $request->meeting_id);
        }
        
        // ... other filters
        
        $attendances = $query->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="attendance_export_' . now()->format('Y-m-d') . '.csv"',
        ];
        
        $callback = function() use ($attendances) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'Staff Name',
                'Department',
                'Meeting',
                'Date',
                'Present',
                'Late',
                'Absent',
                'Join Time',
                'Leave Time',
                'Notes',
                'Approved',
                'Approved By'
            ]);
            
            // Rows
            foreach ($attendances as $attendance) {
                fputcsv($file, [
                    $attendance->staff_name,
                    $attendance->department,
                    $attendance->meeting->title ?? 'N/A',
                    $attendance->created_at->format('Y-m-d'),
                    $attendance->status === 'present' ? 'Yes' : 'No',
                    $attendance->status === 'late' ? 'Yes' : 'No',
                    $attendance->status === 'absent' ? 'Yes' : 'No',
                    $attendance->join_time ? $attendance->join_time->format('H:i') : 'N/A',
                    $attendance->leave_time ? $attendance->leave_time->format('H:i') : 'N/A',
                    $attendance->notes ?? '',
                    $attendance->is_approved ? 'Yes' : 'No',
                    $attendance->approver->name ?? 'N/A'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function topPerformers(Request $request)
{
    $dateRange = $request->get('date_range', 'month');
    $limit = $request->get('limit', 10);
    $type = $request->get('type', 'top'); // top or low
    
    $startDate = match($dateRange) {
        'week' => Carbon::now()->startOfWeek(),
        'month' => Carbon::now()->startOfMonth(),
        'quarter' => Carbon::now()->startOfQuarter(),
        'year' => Carbon::now()->startOfYear(),
        default => Carbon::now()->startOfMonth(),
    };

    $endDate = Carbon::now();

    $performers = StaffMeetingAttendance::select(
            'staff_id',
            'staff_name',
            'department',
            DB::raw('COUNT(*) as total_meetings'),
            DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count'),
            DB::raw('SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_count'),
            DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count'),
            DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_percentage')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('staff_id', 'staff_name', 'department')
        ->having('total_meetings', '>=', 3) // At least 3 meetings to qualify
        ->orderBy('attendance_percentage', $type === 'top' ? 'desc' : 'asc')
        ->limit($limit)
        ->get();

    // Calculate department averages
    $departmentAverages = StaffMeetingAttendance::whereBetween('created_at', [$startDate, $endDate])
        ->select(
            'department',
            DB::raw('COUNT(*) as total'),
            DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as avg_percentage')
        )
        ->whereNotNull('department')
        ->groupBy('department')
        ->get()
        ->keyBy('department');

    return view('admin.attendance.top-performers', compact(
        'performers',
        'departmentAverages',
        'dateRange',
        'type',
        'startDate',
        'endDate'
    ));
}

public function warningList(Request $request)
{
    $dateRange = $request->get('date_range', 'month');
    $warningThreshold = $request->get('threshold', 60); // Below 60%
    $minMeetings = $request->get('min_meetings', 5); // At least 5 meetings
    
    $startDate = match($dateRange) {
        'week' => Carbon::now()->startOfWeek(),
        'month' => Carbon::now()->subDays(30),
        'quarter' => Carbon::now()->subDays(90),
        default => Carbon::now()->subDays(30),
    };

    $endDate = Carbon::now();

    // Get staff with low attendance
    $warningList = StaffMeetingAttendance::select(
            'staff_id',
            'staff_name',
            'department',
            DB::raw('COUNT(*) as total_meetings'),
            DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count'),
            DB::raw('SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_count'),
            DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count'),
            DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_percentage')
        )
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('staff_id', 'staff_name', 'department')
        ->having('total_meetings', '>=', $minMeetings)
        ->having('attendance_percentage', '<', $warningThreshold)
        ->orderBy('attendance_percentage', 'asc')
        ->get();

    // Get repeated absences (3+ consecutive absences)
    $repeatedAbsences = $this->getRepeatedAbsences($startDate, $endDate);

    return view('admin.attendance.warning-list', compact(
        'warningList',
        'repeatedAbsences',
        'dateRange',
        'warningThreshold',
        'minMeetings',
        'startDate',
        'endDate'
    ));
}

private function getRepeatedAbsences($startDate, $endDate)
{
    // Get all staff with their attendance patterns
    $staffAttendance = StaffMeetingAttendance::whereBetween('created_at', [$startDate, $endDate])
        ->select('staff_id', 'staff_name', 'department', 'status', 'created_at')
        ->orderBy('staff_id')
        ->orderBy('created_at')
        ->get()
        ->groupBy('staff_id');

    $repeatedAbsences = [];

    foreach ($staffAttendance as $staffId => $attendances) {
        $consecutiveAbsent = 0;
        $maxConsecutiveAbsent = 0;
        
        foreach ($attendances as $attendance) {
            if ($attendance->status === 'absent') {
                $consecutiveAbsent++;
                $maxConsecutiveAbsent = max($maxConsecutiveAbsent, $consecutiveAbsent);
            } else {
                $consecutiveAbsent = 0;
            }
        }

        if ($maxConsecutiveAbsent >= 3) { // 3+ consecutive absences
            $repeatedAbsences[] = [
                'staff_id' => $staffId,
                'staff_name' => $attendances->first()->staff_name,
                'department' => $attendances->first()->department,
                'consecutive_absences' => $maxConsecutiveAbsent,
                'total_absences' => $attendances->where('status', 'absent')->count(),
                'total_meetings' => $attendances->count(),
            ];
        }
    }

    // Sort by consecutive absences
    usort($repeatedAbsences, function($a, $b) {
        return $b['consecutive_absences'] <=> $a['consecutive_absences'];
    });

    return $repeatedAbsences;
}
}