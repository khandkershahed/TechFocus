<?php

namespace App\Mail;

use App\Models\Admin\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $notificationMessage;
    public $notificationType;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Contact $contact, $notificationMessage, $notificationType = 'general')
    {
        $this->contact = $contact;
        $this->notificationMessage = $notificationMessage;
        $this->notificationType = $notificationType;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $subject = match($this->notificationType) {
            'status_update' => 'Status Update on Your Inquiry - ' . config('app.name'),
            'important' => 'Important Notification - ' . config('app.name'),
            'reminder' => 'Reminder About Your Contact - ' . config('app.name'),
            default => 'Notification - ' . config('app.name'),
        };

        return new Envelope(subject: $subject);
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.contact-notification',
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