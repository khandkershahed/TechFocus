<?php

namespace App\Mail;

use App\Models\Rfq;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RFQConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $rfq;
    public $products;

    /**
     * Create a new message instance.
     *
     * @param  Rfq  $rfq
     */
    public function __construct(Rfq $rfq)
    {
        $this->rfq = $rfq;

        // Safely load products for the email
        $this->products = $rfq->rfqProducts->map(function ($item) {
            return [
                'product_name' => $item->product_name ?? ($item->product->name ?? 'N/A'),
                'qty' => $item->qty ?? 1,
            ];
        })->toArray();
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('emails.rfq_confirmation')
                    ->subject('RFQ Confirmation');
    }
}
