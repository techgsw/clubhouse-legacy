<?php

namespace App\Mail;

use App\Mentor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MentorFollowUp extends Mailable
{
    use Queueable, SerializesModels;

    public $mentor;
    public $days_since;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Mentor $mentor, $days_since)
    {
        $this->mentor = $mentor;
        $this->days_since = $days_since;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(__('email.info_address'), __('email.info_name'))
            ->subject('Feedback on your latest Clubhouse mentees - theClubhouse®')
            ->markdown('emails.clubhouse-mentor-followup');
    }
}
