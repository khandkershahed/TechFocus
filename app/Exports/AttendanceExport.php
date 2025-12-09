<?php

namespace App\Exports;

use App\Models\StaffMeetingAttendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
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

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Staff Name',
            'Staff ID',
            'Department',
            'Meeting Title',
            'Meeting Date',
            'Status',
            'Join Time',
            'Leave Time',
            'Duration (Minutes)',
            'Late Arrival',
            'Notes',
            'Requires Approval',
            'Approval Status',
            'Approved By',
            'Approval Date',
            'Recorded At',
            'Device IP'
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->id,
            $attendance->staff_name,
            $attendance->staff_id,
            $attendance->department ?? 'N/A',
            $attendance->meeting->title ?? 'N/A',
            $attendance->meeting->date->format('Y-m-d') ?? 'N/A',
            ucfirst($attendance->status),
            $attendance->join_time ? $attendance->join_time->format('Y-m-d H:i:s') : 'N/A',
            $attendance->leave_time ? $attendance->leave_time->format('Y-m-d H:i:s') : 'N/A',
            $attendance->durationInMinutes(),
            $attendance->isLate() ? 'Yes' : 'No',
            $attendance->notes ?? '',
            $attendance->requires_approval ? 'Yes' : 'No',
            $attendance->is_approved ? 'Approved' : ($attendance->requires_approval ? 'Pending' : 'N/A'),
            $attendance->approver->name ?? 'N/A',
            $attendance->approved_at ? $attendance->approved_at->format('Y-m-d H:i:s') : 'N/A',
            $attendance->created_at->format('Y-m-d H:i:s'),
            $attendance->device_ip ?? 'N/A'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Attendance Records';
    }
}