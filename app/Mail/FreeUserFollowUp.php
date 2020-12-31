<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FreeUserFollowUp extends Mailable
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
            case "benefits":
                return $this->from('clubhouse@sportsbusiness.solutions', 'Bob Hamer')
                    ->subject("Your Clubhouse Benefits")
                    ->markdown('emails.follow-up.free.benefits');
            case "content":
                return $this->from('clubhouse@sportsbusiness.solutions', 'Bob Hamer')
                    ->subject("Maximizing the Clubhouse experience")
                    ->markdown('emails.follow-up.free.content');
            case "first_30":
                return $this->from('bob@sportsbusiness.solutions', 'Bob Hamer')
                    ->subject("Your one-month update ")
                    ->markdown('emails.follow-up.free.first-30');
            case "reengagement":
                return $this->from('clubhouse@sportsbusiness.solutions', 'Bob Hamer')
                    ->subject("We miss you!")
                    ->markdown('emails.follow-up.free.reengagement');
            default:
                // TODO logger error?
                break;
        }
    }
}
