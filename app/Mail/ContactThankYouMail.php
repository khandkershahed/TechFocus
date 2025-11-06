<?php

namespace App\Mail;

use App\Models\Admin\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactThankYouMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $thankYouMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, $thankYouMessage = null)
    {
        $this->contact = $contact;
        $this->thankYouMessage = $thankYouMessage ?? 'Thank you for contacting us. We appreciate your message and will get back to you soon.';
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Thank You for Contacting Us - ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.contact-thank-you',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}