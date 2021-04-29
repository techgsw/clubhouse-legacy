<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClubhouseFailedPaymentNotice extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $attempt_count;
    public $next_attempt_date;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $attempt_count, $next_attempt_date)
    {
        $this->user = $user;
        $this->attempt_count = $attempt_count;
        $this->next_attempt_date = $next_attempt_date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->attempt_count < 4) {
            return $this->from('app@sportsbusiness.solutions')
                ->subject('Failed Payment Notice - theClubhouse®')
                ->markdown('emails.clubhouse-failed-payment-notice');
        } else {
            return $this->from('app@sportsbusiness.solutions')
                ->subject('Failed Payment: FINAL NOTICE - theClubhouse®')
                ->markdown('emails.clubhouse-failed-payment-final-notice');
        }
    }
}
