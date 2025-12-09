<?php

namespace App\Http\Controllers\Admin;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\StaffMeetingAttendance;

class StaffAttendanceController extends Controller
{
  public function monthlySummary(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        $department = $request->get('department');
        $staffId = $request->get('staff_id');

        // Get all months for dropdown
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $months[$i] = Carbon::create()->month($i)->format('F');
        }

        // Get years from attendance records
        $years = StaffMeetingAttendance::selectRaw('YEAR(created_at) as year')
            ->groupBy(DB::raw('YEAR(created_at)'))
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Query for monthly summary
        $query = StaffMeetingAttendance::select(
                'staff_id',
                'staff_name',
                'department',
                DB::raw('COUNT(*) as total_meetings'),
                DB::raw('SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present_count'),
                DB::raw('SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late_count'),
                DB::raw('SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent_count'),
                DB::raw('SUM(CASE WHEN status = "on_leave" THEN 1 ELSE 0 END) as leave_count'),
                DB::raw('ROUND((SUM(CASE WHEN status IN ("present", "late") THEN 1 ELSE 0 END) / COUNT(*)) * 100, 2) as attendance_percentage')
            )
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->groupBy('staff_id', 'staff_name', 'department');

        // Apply filters
        if ($department) {
            $query->where('department', $department);
        }

        if ($staffId) {
            $query->where('staff_id', $staffId);
        }

        $summary = $query->orderBy('attendance_percentage', 'desc')
            ->paginate(20);

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

        return view('admin.attendance.monthly-summary', compact(
            'summary',
            'departmentStats',
            'months',
            'years',
            'year',
            'month',
            'department',
            'staffId'
        ));
    }
}