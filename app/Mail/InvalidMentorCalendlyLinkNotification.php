<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvalidMentorCalendlyLinkNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $mentor;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mentor)
    {
        $this->mentor = $mentor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(__('email.info_address'))
            ->subject('Your Mentor Calend.ly link appears to be invalid')
            ->markdown('emails.mentor.invalid-calendly-link');
    }
}



