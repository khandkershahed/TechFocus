<?php
// app/Models/StaffMeeting.php

namespace App\Models;

use QrCode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffMeeting extends Model
{
    use HasFactory;

     protected $fillable = [
        'admin_id', 'lead_by', 'title', 'date', 'start_time', 'end_time',
        'participants', 'type', 'category', 'department', 'platform',
        'online_platform', 'organizer_id', 'agenda', 'notes', 'attachments',
        'status', 'email_reminder_sent_at', 'whatsapp_reminder_sent_at',
        'reminder_message', 'attendance_link', 'attendance_qr_code',
        'meeting_minutes', 'minutes_attachments', 'minutes_uploaded_by',
        'minutes_uploaded_at', 'minutes_status', 'approved_by',
        'approved_at', 'approval_notes', 'meeting_link',
        'auto_generate_link', 'send_auto_reminders'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'participants' => 'array',
        'attachments' => 'array',
        'minutes_attachments' => 'array',
        'email_reminder_sent_at' => 'datetime',
        'whatsapp_reminder_sent_at' => 'datetime',
        'minutes_uploaded_at' => 'datetime',
        'approved_at' => 'datetime',
        'auto_generate_link' => 'boolean',
        'send_auto_reminders' => 'boolean',
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

    public function minutesUploader()
    {
        return $this->belongsTo(Admin::class, 'minutes_uploaded_by');
    }

    public function approver()
    {
        return $this->belongsTo(Admin::class, 'approved_by');
    }

    public function getMeetingDurationAttribute()
    {
        if ($this->start_time && $this->end_time) {
            return $this->start_time->diff($this->end_time)->format('%H:%I');
        }
        return null;
    }

    public function getMinutesStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger'
        ];
        
        $color = $statuses[$this->minutes_status] ?? 'secondary';
        
        return '<span class="badge bg-' . $color . '">' . ucfirst($this->minutes_status) . '</span>';
    }



    public function canUploadMinutes()
    {
        return $this->status === 'completed';
    }

    public function canApproveMinutes()
    {
        return $this->minutes_status === 'pending' && 
               $this->meeting_minutes !== null;
    }

    // Generate QR Code for attendance
    public function generateAttendanceQRCode()
    {
        if (!$this->attendance_link) {
            // Generate a unique attendance link
            $this->attendance_link = route('meeting.attendance', ['id' => $this->id, 'token' => md5($this->id . env('APP_KEY'))]);
            $this->save();
        }

        // Generate QR code using Simple QrCode package
        // First install: composer require simplesoftwareio/simple-qrcode
        
        $qrCode = QrCode::size(200)
            ->format('png')
            ->generate($this->attendance_link);
        
        $fileName = 'qr_codes/meeting_' . $this->id . '.png';
        Storage::disk('public')->put($fileName, $qrCode);
        
        $this->attendance_qr_code = $fileName;
        $this->save();
        
        return $fileName;
    }


public function getParticipantsListAttribute()
{
    $ids = is_array($this->participants)
        ? $this->participants
        : json_decode($this->participants, true);

    return \App\Models\Admin::whereIn('id', $ids ?? [])->get();
}

public function canSendReminder()
{
    return $this->status === 'scheduled'
        && $this->date >= now()->subDay()
        && $this->date <= now()->addDays(7);
}
// Add this method to your existing StaffMeeting model
public function attendances()
{
    return $this->hasMany(StaffMeetingAttendance::class, 'meeting_id');
}

public function presentAttendances()
{
    return $this->attendances()->where('status', 'present');
}

public function attendancePercentage()
{
    $totalParticipants = count(json_decode($this->participants, true) ?? []);
    if ($totalParticipants === 0) return 0;
    
    $presentCount = $this->presentAttendances()->count();
    return round(($presentCount / $totalParticipants) * 100, 2);
}
}