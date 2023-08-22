<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendGiftEmailSender extends Mailable
{
    use Queueable, SerializesModels;
    public $gift_info;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($gift_info)
    {
        $this->gift_info = $gift_info;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('credentials.admin_email_address'))
        ->subject("CryptoGifting Transaction Successful")
        ->view("emails.sender-gift-mail");
    }
}
