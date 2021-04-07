<?php

namespace App\Mail;

use App\User;
use App\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewJobTypeMatchPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $jobs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Job ...$jobs)
    {
        $this->user = $user;
        $this->jobs = $jobs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('clubhouse@sportsbusiness.solutions', 'theClubhouse')
            ->subject("New jobs in sports")
            ->markdown('emails.new-job-type-match-posted');
    }
}

