<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClubhouseFollowUp extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $follow_up_type;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $follow_up_type)
    {
        $this->user = $user;
        $this->follow_up_type = $follow_up_type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        switch ($this->follow_up_type) {
            case "connected":
                return $this->from('theclubhouse@generalsports.com', 'theClubhouse Team')
                    ->subject("Have we connected yet?")
                    ->markdown('emails.follow-up.clubhouse.connected');
            case "networking":
                return $this->from('theclubhouse@generalsports.com', 'theClubhouse Team')
                    ->subject("Talk with sports industry mentors")
                    ->markdown('emails.follow-up.clubhouse.networking');
            case "webinars":
                return $this->from('theclubhouse@generalsports.com', 'theClubhouse Team')
                    ->subject("Sports Industry Best Practices")
                    ->markdown('emails.follow-up.clubhouse.webinars');
            case "career_services":
                return $this->from('theclubhouse@generalsports.com', 'theClubhouse Team')
                    ->subject("Want 1 on 1 career advice?")
                    ->markdown('emails.follow-up.clubhouse.career-services');
            case "first_30":
                return $this->from('bob@sportsbusiness.solutions', 'theClubhouse Team')
                    ->subject("Your first 30 days as a PRO")
                    ->markdown('emails.follow-up.clubhouse.first-30');
            default:
                // TODO logger error?
                break;
        }
    }
}
