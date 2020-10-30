<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MenteeFollowUp extends Mailable
{
    use Queueable, SerializesModels;

    public $mentee;
    public $days_since;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $mentee, $days_since)
    {
        $this->mentee = $mentee;
        $this->days_since = $days_since;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('clubhouse@sportsbusiness.solutions', 'theClubhouse')
            ->subject('Feedback on your latest Clubhouse mentors - theClubhouse')
            ->markdown('emails.clubhouse-mentee-followup');
    }
}
