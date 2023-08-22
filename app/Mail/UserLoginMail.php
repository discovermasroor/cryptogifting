<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserLoginMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $system;
    public $browser;
    public $ip;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $system, $browser, $ip)
    {
        $this->user = $user;
        $this->system = $system;
        $this->browser = $browser;
        $this->ip = $ip;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('credentials.admin_email_address'))
        ->subject("Your CryptoGifting Sign-in confirmation code")
        ->view("emails.user-login");
    }
}
