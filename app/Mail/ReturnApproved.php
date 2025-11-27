<?php

namespace App\Mail;

use App\Models\ReturnRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReturnApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $returnRequest;

    public function __construct(ReturnRequest $returnRequest)
    {
        $this->returnRequest = $returnRequest;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Return Approved - Order #' . $this->returnRequest->order_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.return-approved',  
        );
    }
}
