<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\StaffMeeting;
use App\Models\Admin;

class MeetingReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $meeting;
    public $participant;

    public function __construct(StaffMeeting $meeting, Admin $participant)
    {
        $this->meeting = $meeting;
        $this->participant = $participant;
    }

    public function build()
    {
        return $this->subject('Meeting Reminder: ' . $this->meeting->title)
                    ->view('emails.meeting-reminder')
                    ->with([
                        'meeting' => $this->meeting,
                        'participant' => $this->participant,
                    ]);
    }
}