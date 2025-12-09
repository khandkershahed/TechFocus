<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected function schedule(Schedule $schedule)
{
    // Run every hour
    $schedule->command('rfq:send-reminders')->hourly();
     // Send meeting reminders every minute
    $schedule->command('meetings:send-reminders')->everyMinute();
    
    // Auto-complete past meetings daily at midnight
    $schedule->command('meetings:auto-complete')->daily();
    
    // Send daily meeting digest at 8 AM
    $schedule->command('meetings:send-daily-digest')->dailyAt('08:00');
}

}
