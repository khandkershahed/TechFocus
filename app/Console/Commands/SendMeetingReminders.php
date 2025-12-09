<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StaffMeeting;
use App\Models\Admin;
use App\Mail\MeetingReminderMail;
use Illuminate\Support\Facades\Mail;

class SendMeetingReminders extends Command
{
    protected $signature = 'meetings:send-reminders';
    protected $description = 'Send automatic meeting reminders';

    public function handle()
    {
        // Find meetings starting in the next 1 hour that haven't had reminders sent
        $meetings = StaffMeeting::where('status', 'scheduled')
            ->where('send_auto_reminders', true)
            ->whereNull('email_reminder_sent_at')
            ->whereBetween('start_time', [now(), now()->addHour()])
            ->get();

        foreach ($meetings as $meeting) {
            $this->info("Sending reminders for meeting: {$meeting->title}");
            
            $participants = $meeting->getParticipantsListAttribute();
            
            foreach ($participants as $participant) {
                Mail::to($participant->email)->queue(new MeetingReminderMail($meeting, $participant));
            }
            
            $meeting->update(['email_reminder_sent_at' => now()]);
            
            $this->info("Sent to {$participants->count()} participants");
        }
        
        $this->info("Reminder sending completed.");
    }
}