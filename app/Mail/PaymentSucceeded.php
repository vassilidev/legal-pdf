<?php

namespace App\Mail;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentSucceeded extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected Order $order
    )
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Succeeded',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.paymentSucceeded',
            with: [
                'order' => $this->order,
            ],
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
            Attachment::fromData(
                data: fn() => Pdf::loadView('pdf.invoice', [
                    'order' => $this->order,
                ])->output(),
                name: 'invoice.pdf'
            ),
            Attachment::fromData(
                data: function () {
                    $answers = $this->order->answers['data'];
                    $contract = $this->order->contract;
                    $order = $this->order;

                    return Pdf::loadView('contracts.pdf', compact('contract', 'answers', 'order'))->output();
                },
                name: 'Contract ' . $this->order->contract->name . '.pdf',
            )
        ];
    }
}
