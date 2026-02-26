<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $isAdmin;
    public $company_info;
    public $pdfData;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $isAdmin = false, $pdfData = null)
    {
        $this->order = $order;
        $this->isAdmin = $isAdmin;
        $this->company_info = \App\Models\CompanyInfo::first();
        $this->pdfData = $pdfData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->isAdmin 
            ? 'Nouvelle commande - ' . ($this->order->product_name ?? 'Remorques Industrie')
            : 'Bestellbestätigung - ' . ($this->order->product_name ?? 'Remorques Industrie');

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
            markdown: 'emails.orders.notification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->pdfData) {
            return [
                \Illuminate\Mail\Mailables\Attachment::fromData(
                    fn () => $this->pdfData['content'],
                    $this->pdfData['file_name']
                )->withMime('application/pdf'),
            ];
        }

        return [];
    }
}
