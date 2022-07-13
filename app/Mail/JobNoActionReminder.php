<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobNoActionReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $jobs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $jobs)
    {
        $this->jobs = $jobs;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(__('email.support_address'))
                    ->subject('Reminder: Job Applications Requiring Action - theClubhouse®')
                    ->markdown('emails.inquiry.no-action-reminder');
    }
}
