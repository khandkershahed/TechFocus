<?php

namespace App\Mail;


use App\Models\Rfq;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\Rfq\RfqProduct;
use Illuminate\Queue\SerializesModels;

class RfqNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rfq;
    public $products;
    public $subject;

    /**
     * Create a new message instance.
     */
    public function __construct(Rfq $rfq, string $subject = null)
    {
        $this->rfq = $rfq;

        // Get RFQ products from database
        $this->products = RfqProduct::where('rfq_id', $rfq->id)->get();

        // Fallback to products_data if no products found
        if ($this->products->isEmpty() && $rfq->products_data) {
            $this->products = collect(json_decode($rfq->products_data, true));
        }

        $this->subject = $subject ?? 'New RFQ Submitted - ' . $rfq->rfq_code;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.rfq-notification')
                    ->with([
                        'rfq' => $this->rfq,
                        'products' => $this->products,
                    ]);
    }
}
