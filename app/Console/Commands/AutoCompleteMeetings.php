<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StaffMeeting;

class AutoCompleteMeetings extends Command
{
    protected $signature = 'meetings:auto-complete';
    protected $description = 'Auto-complete past meetings';

    public function handle()
    {
        // Find meetings that ended more than 1 hour ago but still marked as scheduled
        $meetings = StaffMeeting::where('status', 'scheduled')
            ->where('end_time', '<', now()->subHour())
            ->get();

        foreach ($meetings as $meeting) {
            $meeting->update(['status' => 'completed']);
            $this->info("Auto-completed meeting: {$meeting->title}");
        }

        $this->info("Auto-completed {$meetings->count()} meetings.");
    }
}