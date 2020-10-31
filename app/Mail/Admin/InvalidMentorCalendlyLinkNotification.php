<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvalidMentorCalendlyLinkNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $mentors;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mentors)
    {
        $this->mentors = $mentors;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@sportsbusiness.solutions')
            ->subject('Invalid Calend.ly links found for mentors - theClubhouse')
            ->markdown('emails.internal.invalid-mentor-calendly-link');
    }
}


