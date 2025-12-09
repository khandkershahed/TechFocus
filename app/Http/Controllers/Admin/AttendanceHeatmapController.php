<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaffMeetingAttendance;
use App\Models\StaffMeeting;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceHeatmapController extends Controller
{
    public function index(Request $request)
    {
        $meetingId = $request->get('meeting_id');
        $dateRange = $request->get('date_range', 'month');
        
        $meetings = StaffMeeting::orderBy('date', 'desc')->get();

        if ($meetingId) {
            $heatmapData = $this->getMeetingHeatmap($meetingId);
            $meeting = StaffMeeting::find($meetingId);
        } else {
            $heatmapData = $this->getDateRangeHeatmap($dateRange);
            $meeting = null;
        }

        return view('admin.attendance.heatmap', compact(
            'heatmapData',
            'meetings',
            'meetingId',
            'dateRange',
            'meeting'
        ));
    }

    private function getMeetingHeatmap($meetingId)
    {
        $meeting = StaffMeeting::with(['attendances', 'attendances.staff'])->find($meetingId);
        
        if (!$meeting) {
            return [];
        }

        $heatmap = [];
        $participants = json_decode($meeting->participants, true) ?? [];
        
        foreach ($participants as $participantId) {
            $attendance = $meeting->attendances->where('staff_id', $participantId)->first();
            $staff = \App\Models\Admin::find($participantId);
            
            if ($staff) {
                $heatmap[] = [
                    'staff_id' => $staff->id,
                    'staff_name' => $staff->name,
                    'department' => $staff->department,
                    'status' => $attendance ? $attendance->status : 'absent',
                    'join_time' => $attendance ? $attendance->join_time : null,
                    'color' => $this->getStatusColor($attendance ? $attendance->status : 'absent'),
                    'icon' => $this->getStatusIcon($attendance ? $attendance->status : 'absent'),
                ];
            }
        }

        return $heatmap;
    }

    private function getDateRangeHeatmap($dateRange)
    {
        $startDate = match($dateRange) {
            'week' => Carbon::now()->startOfWeek(),
            'month' => Carbon::now()->startOfMonth(),
            'quarter' => Carbon::now()->startOfQuarter(),
            default => Carbon::now()->startOfMonth(),
        };

        $endDate = Carbon::now();

        // Get all meetings in date range
        $meetings = StaffMeeting::whereBetween('date', [$startDate, $endDate])
            ->with('attendances')
            ->get();

        $heatmap = [];
        $staffAttendance = [];

        // Group attendance by staff
        foreach ($meetings as $meeting) {
            foreach ($meeting->attendances as $attendance) {
                $staffId = $attendance->staff_id;
                
                if (!isset($staffAttendance[$staffId])) {
                    $staff = \App\Models\Admin::find($staffId);
                    if ($staff) {
                        $staffAttendance[$staffId] = [
                            'staff' => $staff,
                            'total_meetings' => 0,
                            'attended' => 0,
                            'late' => 0,
                            'absent' => 0,
                            'details' => []
                        ];
                    }
                }

                if (isset($staffAttendance[$staffId])) {
                    $staffAttendance[$staffId]['total_meetings']++;
                    
                    if ($attendance->status === 'present') {
                        $staffAttendance[$staffId]['attended']++;
                    } elseif ($attendance->status === 'late') {
                        $staffAttendance[$staffId]['late']++;
                    } elseif ($attendance->status === 'absent') {
                        $staffAttendance[$staffId]['absent']++;
                    }

                    $staffAttendance[$staffId]['details'][] = [
                        'meeting' => $meeting->title,
                        'date' => $meeting->date->format('M d'),
                        'status' => $attendance->status,
                        'color' => $this->getStatusColor($attendance->status),
                    ];
                }
            }
        }

        // Convert to heatmap format
        foreach ($staffAttendance as $data) {
            $attendanceRate = $data['total_meetings'] > 0 
                ? round((($data['attended'] + $data['late']) / $data['total_meetings']) * 100, 2)
                : 0;

            $heatmap[] = [
                'staff_id' => $data['staff']->id,
                'staff_name' => $data['staff']->name,
                'department' => $data['staff']->department,
                'total_meetings' => $data['total_meetings'],
                'attended' => $data['attended'],
                'late' => $data['late'],
                'absent' => $data['absent'],
                'attendance_rate' => $attendanceRate,
                'heat_color' => $this->getHeatColor($attendanceRate),
                'details' => $data['details'],
            ];
        }

        // Sort by attendance rate
        usort($heatmap, function($a, $b) {
            return $b['attendance_rate'] <=> $a['attendance_rate'];
        });

        return $heatmap;
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'present' => '#28a745', // Green
            'late' => '#ffc107',    // Yellow
            'absent' => '#dc3545',  // Red
            'on_leave' => '#17a2b8', // Blue
            'work_from_field' => '#6f42c1', // Purple
            default => '#6c757d'    // Gray
        };
    }

    private function getHeatColor($percentage)
    {
        if ($percentage >= 90) return '#28a745'; // Green
        if ($percentage >= 70) return '#20c997'; // Teal
        if ($percentage >= 50) return '#ffc107'; // Yellow
        if ($percentage >= 30) return '#fd7e14'; // Orange
        return '#dc3545'; // Red
    }

    private function getStatusIcon($status)
    {
        return match($status) {
            'present' => '✓',
            'late' => '⚠',
            'absent' => '✗',
            'on_leave' => '🌴',
            'work_from_field' => '📍',
            default => '?'
        };
    }
}