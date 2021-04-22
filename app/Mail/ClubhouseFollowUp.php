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
                return $this->from('clubhouse@sportsbusiness.solutions', 'Bob Hamer')
                    ->subject("Have we connected yet?")
                    ->markdown('emails.follow-up.clubhouse.connected');
            case "networking":
                return $this->from('clubhouse@sportsbusiness.solutions', 'Bob Hamer')
                    ->subject("Talk with sports industry mentors")
                    ->markdown('emails.follow-up.clubhouse.networking');
            case "webinars":
                return $this->from('clubhouse@sportsbusiness.solutions', 'Bob Hamer')
                    ->subject("Sports Industry Best Practices")
                    ->markdown('emails.follow-up.clubhouse.webinars');
            case "first_30":
                return $this->from('bob@sportsbusiness.solutions', 'Bob Hamer')
                    ->subject("Your first 30 days as a PRO")
                    ->markdown('emails.follow-up.clubhouse.first-30');
            default:
                // TODO logger error?
                break;
        }
    }
}
