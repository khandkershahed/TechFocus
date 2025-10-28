<?php

namespace App\Console\Commands;

use App\Models\Rfq;
use App\Mail\RfqReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SendRfqReminders extends Command
{
    protected $signature = 'rfq:send-reminders';
    protected $description = 'Send reminder emails for RFQs not responded to within 24h, 48h, and 72h';

    public function handle()
    {
        Log::info('=== Running RFQ Reminder Check ===');

        // Define reminder intervals (in hours)
        $reminderHours = [24, 48, 72];

        foreach ($reminderHours as $hours) {
            $this->sendRemindersForInterval($hours);
        }

        Log::info('=== RFQ Reminder Check Complete ===');
    }

    private function sendRemindersForInterval(int $hours)
    {
        Log::info("🔍 Checking for RFQs pending for {$hours} hours...");

        // Select RFQs that are still 'rfq_created' and match the specific time window
        $rfqs = Rfq::where('status', 'rfq_created')
            ->whereRaw('TIMESTAMPDIFF(HOUR, created_at, NOW()) >= ?', [$hours])
            ->whereRaw('TIMESTAMPDIFF(HOUR, created_at, NOW()) < ?', [$hours + 1]) // within 1-hour window
            ->whereColumn('created_at', '=', 'updated_at')
            ->get();

        if ($rfqs->isEmpty()) {
            Log::info("No RFQs found for {$hours}-hour reminder.");
            return;
        }

        Log::info("Found {$rfqs->count()} RFQs for {$hours}-hour reminder.");

        foreach ($rfqs as $rfq) {
            try {
                $recipients = $this->getAdminEmails();

                foreach ($recipients as $recipient) {
                    Mail::to($recipient)->send(new RfqReminderMail($rfq, $hours)); // pass $hours to email
                }

                Log::info("{$hours}-hour reminder sent for RFQ: {$rfq->rfq_code}");
            } catch (\Exception $e) {
                Log::error(" Failed to send {$hours}-hour reminder for RFQ {$rfq->rfq_code}: " . $e->getMessage());
            }
        }
    }

    private function getAdminEmails(): array
    {
        return [
            'site2.ngenit@gmail.com',
            'techfcousltd@gmail.com',
            'dev2.ngenit@gmail.com',
            'dev1.ngenit@gmail.com',
            'dev3.ngenit@gmail.com',
        ];
    }
}
