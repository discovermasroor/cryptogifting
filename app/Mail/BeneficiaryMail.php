<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BeneficiaryMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $beneficiary;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $beneficiary)
    {
        $this->user = $user;
        $this->beneficiary = $beneficiary;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user_name = $this->user->username;
        if ($this->user->first_name != '' && $this->user->last_name != '') {
            $user_name = ucfirst($this->user->first_name).' '.ucfirst($this->user->last_name);
        }
        return $this->from(config('credentials.admin_email_address'))
        ->subject("New Beneficiary added with CryptoGifting.com")
        ->view("emails.add-beneficiary");
    }
}
