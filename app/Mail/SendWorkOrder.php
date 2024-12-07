<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWorkOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $workorder;
    public $urlworkorder;
    public $namepdf;
    /**
     * Create a new message instance.
     */
    public function __construct($workorder, $urlworkorder, $namepdf)
    {
        $this->workorder = $workorder;
        $this->urlworkorder = $urlworkorder;
        $this->namepdf = $namepdf;
    }


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'TIGroup - Orden de Trabajo',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'workorders.mail.email-workorder',
            with: [
                'workorder' => $this->workorder
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
            Attachment::fromPath($this->urlworkorder)
                ->as($this->namepdf)
                ->withMime('application/pdf'),
        ];
    }
}
