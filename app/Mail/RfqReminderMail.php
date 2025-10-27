<?php

namespace App\Mail;

use App\Models\Rfq;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RfqReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rfq;

    /**
     * Create a new message instance.
     */
    public function __construct(Rfq $rfq)
    {
        $this->rfq = $rfq;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject(' Reminder: Pending RFQ - ' . $this->rfq->rfq_code)
            ->view('emails.rfq_reminder')
            ->with([
                'rfq' => $this->rfq,
            ]);
    }
}
