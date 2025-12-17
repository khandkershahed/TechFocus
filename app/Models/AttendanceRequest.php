<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRequest extends Model
{
    protected $fillable = [
        'meeting_id',
        'staff_id',
        'status',
        'approved_by',
        'approved_at',
        'admin_notes'
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'approved_at' => 'datetime'
    ];

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
}