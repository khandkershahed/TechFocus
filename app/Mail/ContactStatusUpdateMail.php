<?php

namespace App\Mail;

use App\Models\Admin\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactStatusUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $oldStatus;
    public $newStatus;
    public $updateMessage;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, $newStatus, $updateMessage = null)
    {
        $this->contact = $contact;
        $this->oldStatus = $contact->status;
        $this->newStatus = $newStatus;
        $this->updateMessage = $updateMessage;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Status Update: Your Request is Now ' . ucfirst($this->newStatus) . ' - ' . config('app.name'),
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
            view: 'emails.contact-status-update',
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