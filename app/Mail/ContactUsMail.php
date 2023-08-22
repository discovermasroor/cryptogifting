<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contact_us;
    public $subject;
    public $view;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($contact_us, $subject, $view)
    {
        $this->contact_us = $contact_us;
        $this->subject = $subject;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->contact_us->file) {
            return $this->from(config('credentials.admin_email_address'))
            ->subject($this->subject)
            ->view("emails.".$this->view)->attach($this->contact_us->file_url);

        } else {
            return $this->from(config('credentials.admin_email_address'))
            ->subject($this->subject)
            ->view("emails.".$this->view);

        }
    }
}
