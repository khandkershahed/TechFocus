<?php

namespace App\Console\Commands;

use App\Models\Rfq;
use App\Mail\RfqReminderMail; // ✅ Add this line
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendRfqReminders extends Command
{
    protected $signature = 'rfq:send-reminders';
    protected $description = 'Send reminder emails for RFQs not responded to within 24 hours';

    public function handle()
    {
        Log::info('=== Running RFQ Reminder Check ===');

        $rfqs = Rfq::where('status', 'rfq_created')
            ->whereRaw('TIMESTAMPDIFF(HOUR, created_at, NOW()) >= 24')
            ->whereColumn('created_at', '=', 'updated_at') 
            ->get();

        if ($rfqs->isEmpty()) {
            Log::info('No pending RFQs for reminder.');
            return;
        }

        Log::info("Found {$rfqs->count()} RFQs for reminder.");

        foreach ($rfqs as $rfq) {
            // Optional safety check
            if ($rfq->updated_at->diffInHours($rfq->created_at) > 0) {
                Log::info("⏩ RFQ {$rfq->rfq_code} was already updated, skipping reminder.");
                continue;
            }

            try {
                $recipients = $this->getAdminEmails();

                foreach ($recipients as $recipient) {
                    // ✅ Use the new Reminder mail
                    Mail::to($recipient)->send(new RfqReminderMail($rfq));
                }

                Log::info("✅ Reminder sent for RFQ: {$rfq->rfq_code}");
            } catch (\Exception $e) {
                Log::error(" Failed to send reminder for RFQ {$rfq->rfq_code}: " . $e->getMessage());
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
        ];
    }
}
