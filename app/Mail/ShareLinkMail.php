<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ShareLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $shareUrl;
    public $expiresAt;
    public $senderName;

    public function __construct($shareUrl, $expiresAt, $senderName = null)
    {
        $this->shareUrl = $shareUrl;
        $this->expiresAt = $expiresAt;
        $this->senderName = $senderName ?? 'Principal';
    }

    public function build()
    {
        return $this->subject('Shared Link Access')
                    ->view('emails.share-link')
                    ->with([
                        'shareUrl' => $this->shareUrl,
                        'expiresAt' => $this->expiresAt,
                        'senderName' => $this->senderName,
                    ]);
    }
}