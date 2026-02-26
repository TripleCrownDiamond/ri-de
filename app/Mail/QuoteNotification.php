<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $isAdmin;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $isAdmin = false)
    {
        $this->data = $data;
        $this->isAdmin = $isAdmin;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isAdmin 
            ? 'Nouvelle demande de devis - ' . ($this->data['product'] ?? 'Remorques Industrie')
            : 'Bestätigung Ihrer Angebotsanfrage - ' . ($this->data['product'] ?? config('app.name'));

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.quotes.notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
