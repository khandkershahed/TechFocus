<?php

namespace App\Mail;

use App\Models\Admin\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReplyMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $replyMessage;

    public function __construct(Contact $contact, $replyMessage)
    {
        $this->contact = $contact;
        $this->replyMessage = $replyMessage;
    }

    public function envelope()
    {
        return new Envelope(
            subject: 'Reply to Your Contact Message - ' . config('app.name'),
        );
    }

    public function content()
    {
        return new Content(
            view: 'emails.contact-reply',
        );
    }

    public function attachments()
    {
        return [];
    }
}