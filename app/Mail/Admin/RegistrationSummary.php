<?php

namespace App\Mail\Admin;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RegistrationSummary extends Mailable
{
    use Queueable, SerializesModels;

    public $registrants;
    public $start;
    public $end;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        \DateTime $start,
        \DateTime $end,
        $registrants
    ) {
        $this->start = $start;
        $this->end = $end;
        $this->registrants = $registrants;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('app@sportsbusiness.solutions')
            ->markdown('emails.internal.registration');
    }
}
