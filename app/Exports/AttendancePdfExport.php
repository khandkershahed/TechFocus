<?php

namespace App\Exports;

use App\Models\StaffMeetingAttendance;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AttendancePdfExport implements FromView
{
    protected $filters;
    protected $format;

    public function __construct($filters = [], $format = 'pdf')
    {
        $this->filters = $filters;
        $this->format = $format;
    }

    public function view(): View
    {
        $query = StaffMeetingAttendance::with(['meeting', 'staff', 'approver'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }
        
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }
        
        if (!empty($this->filters['meeting_id'])) {
            $query->where('meeting_id', $this->filters['meeting_id']);
        }
        
        if (!empty($this->filters['department'])) {
            $query->where('department', $this->filters['department']);
        }
        
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        $attendances = $query->get();
        $stats = $this->calculateStats($attendances);

        return view('admin.attendance.exports.pdf', compact('attendances', 'stats', 'filters'));
    }

    private function calculateStats($attendances)
    {
        $total = $attendances->count();
        $present = $attendances->where('status', 'present')->count();
        $late = $attendances->where('status', 'late')->count();
        $absent = $attendances->where('status', 'absent')->count();
        $onLeave = $attendances->where('status', 'on_leave')->count();

        return [
            'total' => $total,
            'present' => $present,
            'late' => $late,
            'absent' => $absent,
            'on_leave' => $onLeave,
            'present_percentage' => $total > 0 ? round(($present / $total) * 100, 2) : 0,
            'attendance_rate' => $total > 0 ? round((($present + $late) / $total) * 100, 2) : 0,
        ];
    }
}