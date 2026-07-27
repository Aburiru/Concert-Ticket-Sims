<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\SerializesModels;

class ETicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function build(): static
    {
        $pdf = Pdf::loadView('ticket.pdf', ['order' => $this->order]);
        $pdfContent = $pdf->output();

        return $this->subject('Your Concert E-Ticket - ' . $this->order->ticket_id)
            ->view('emails.e-ticket')
            ->attachData($pdfContent, 'e-ticket-' . $this->order->ticket_id . '.pdf', [
                'mime' => 'application/pdf',
            ])
            ->with(['order' => $this->order]);
    }
}
