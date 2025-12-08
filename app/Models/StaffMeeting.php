<?php
// app/Models/StaffMeeting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffMeeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'lead_by',
        'title',
        'date',
        'start_time',
        'end_time',
        'participants',
        'type',
        'category',
        'department',
        'platform',
        'online_platform',
        'organizer_id',
        'agenda',
        'notes',
        'attachments',
        'status'
    ];

    protected $casts = [
        'participants' => 'array',
        'attachments' => 'array',
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function leader()
    {
        return $this->belongsTo(Admin::class, 'lead_by');
    }

    public function organizer()
    {
        return $this->belongsTo(Admin::class, 'organizer_id');
    }

    // Scopes
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('date', '>=', now()->toDateString())
                     ->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    // Helper methods
    public function getDurationAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return $this->start_time->diff($this->end_time)->format('%H:%I');
        }
        return null;
    }

    public function isUpcoming()
    {
        return $this->date >= now()->toDateString() && $this->status == 'scheduled';
    }
}