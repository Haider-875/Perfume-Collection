<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdatedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public string $oldStatus = 'pending',
        public string $newStatus = 'confirmed',
        public ?string $comment = null
    ) {
        $this->oldStatus = $oldStatus ?: $order->order_status;
        $this->newStatus = $newStatus ?: $order->order_status;
    }

    public function envelope(): Envelope
    {
        $readableStatus = strtoupper(str_replace('_', ' ', $this->newStatus));
        return new Envelope(
            subject: "Dossier #{$this->order->order_number} Update: {$readableStatus} | Perfumes Collection",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-updated',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
