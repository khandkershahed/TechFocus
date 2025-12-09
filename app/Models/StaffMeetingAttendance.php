<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffMeetingAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'staff_meeting_attendance';
    
    protected $fillable = [
        'meeting_id',
        'staff_id',
        'staff_name',
        'department',
        'status',
        'join_time',
        'leave_time',
        'notes',
        'requires_approval',
        'is_approved',
        'approved_by',
        'approved_at',
        'device_ip',
        'device_agent'
    ];

    protected $casts = [
        'join_time' => 'datetime',
        'leave_time' => 'datetime',
        'approved_at' => 'datetime',
        'requires_approval' => 'boolean',
        'is_approved' => 'boolean',
    ];

    // Relationships
    public function meeting()
    {
        return $this->belongsTo(StaffMeeting::class, 'meeting_id');
    }

    public function staff()
    {
        return $this->belongsTo(Admin::class, 'staff_id');
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    // Scopes
    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    public function scopeOnLeave($query)
    {
        return $query->where('status', 'on_leave');
    }

    public function scopeForMeeting($query, $meetingId)
    {
        return $query->where('meeting_id', $meetingId);
    }

    public function scopeForStaff($query, $staffId)
    {
        return $query->where('staff_id', $staffId);
    }

    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereHas('meeting', function($q) use ($startDate, $endDate) {
            $q->whereBetween('date', [$startDate, $endDate]);
        });
    }

    // Helper methods
    public function isLate()
    {
        if (!$this->join_time || !$this->meeting) {
            return false;
        }

        $meetingStart = $this->meeting->date->copy()->setTimeFrom($this->meeting->start_time);
        $lateThreshold = $meetingStart->addMinutes(15); // 15 minutes grace period

        return $this->join_time->gt($lateThreshold);
    }

    public function durationInMinutes()
    {
        if (!$this->join_time || !$this->leave_time) {
            return 0;
        }

        return $this->join_time->diffInMinutes($this->leave_time);
    }

    public function getAttendanceStatusColor()
    {
        return match($this->status) {
            'present' => 'success',
            'late' => 'warning',
            'absent' => 'danger',
            'on_leave' => 'info',
            'work_from_field' => 'primary',
            default => 'secondary'
        };
    }
}