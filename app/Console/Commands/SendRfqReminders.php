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
        $this->info('=== Running RFQ Reminder Check ===');
        Log::info('=== Running RFQ Reminder Check ===');

        // Define reminder intervals (in hours)
        $reminderHours = [24, 48, 72];

        foreach ($reminderHours as $hours) {
            $this->sendRemindersForInterval($hours);
        }

        $this->info('=== RFQ Reminder Check Complete ===');
        Log::info('=== RFQ Reminder Check Complete ===');
    }

    private function sendRemindersForInterval(int $hours)
    {
        $this->info("🔍 Checking for RFQs pending for {$hours} hours...");
        Log::info("🔍 Checking for RFQs pending for {$hours} hours...");

        $column = "reminder_{$hours}h_sent";

        $rfqs = Rfq::where('status', 'rfq_created')
            ->whereRaw('TIMESTAMPDIFF(HOUR, created_at, NOW()) >= ?', [$hours])
            ->where($column, false) // only those not reminded yet
            ->get();

        if ($rfqs->isEmpty()) {
            $this->info("No RFQs found for {$hours}-hour reminder.");
            Log::info("No RFQs found for {$hours}-hour reminder.");
            return;
        }

        $this->info("Found {$rfqs->count()} RFQs for {$hours}-hour reminder.");
        Log::info("Found {$rfqs->count()} RFQs for {$hours}-hour reminder.");

        foreach ($rfqs as $rfq) {
            try {
                foreach ($this->getAdminEmails() as $recipient) {
                    Mail::to($recipient)->send(new RfqReminderMail($rfq, $hours));
                }

                // Mark reminder as sent
                $rfq->update([$column => true]);

                $this->info("✅ {$hours}-hour reminder sent for RFQ: {$rfq->rfq_code}");
                Log::info("✅ {$hours}-hour reminder sent for RFQ: {$rfq->rfq_code}");
            } catch (\Exception $e) {
                $this->error("❌ Failed to send {$hours}-hour reminder for RFQ {$rfq->rfq_code}: " . $e->getMessage());
                Log::error("❌ Failed to send {$hours}-hour reminder for RFQ {$rfq->rfq_code}: " . $e->getMessage());
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
