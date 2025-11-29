<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdviceRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $senderName;
    public $productName;
    public $productUrl;
    public $message;

    public function __construct($senderName, $productName, $productUrl, $message = '')
    {
        $this->senderName = $senderName;
        $this->productName = $productName;
        $this->productUrl = $productUrl;
        $this->message = $message;
    }

    public function build()
    {
        return $this->subject("{$this->senderName} wants your opinion!")
                    ->view('emails.advice-request');
    }
}
