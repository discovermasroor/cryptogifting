<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmBeneficiaryMail extends Mailable
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
        return $this->from(config('credentials.admin_email_address'))
        ->subject("You have added ".ucfirst($this->beneficiary->name).' '.ucfirst($this->beneficiary->surname)." as a beneficiary!")
        ->view("emails.confirm-beneficiary-added");
    }
}
