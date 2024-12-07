<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPurchaseOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;
    public $urlpurchase;
    public $namepdf;
    /**
     * Create a new message instance.
     */
    public function __construct($purchase, $urlpurchase, $namepdf)
    {
        $this->purchase = $purchase;
        $this->urlpurchase = $urlpurchase;
        $this->namepdf = $namepdf;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'TIGroup - Orden de Compra',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'purchasesorders.mail.email-purchaseorder',
            with: [
                'purchase' => $this->purchase
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->urlpurchase)
                ->as($this->namepdf)
                ->withMime('application/pdf'),
        ];
    }
}
