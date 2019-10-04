<?php

namespace App\Mail;

use App\User;
use App\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FirstJobPostIntroduction extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $job;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Job $job)
    {
        $this->user = $user;
        $this->job = $job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@sportsbusiness.solutions')
                    ->markdown('emails.inquiry.introduction');
    }
}
