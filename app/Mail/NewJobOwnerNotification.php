<?php

namespace App\Mail;

use App\Job;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewJobOwnerNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $job;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Job $job, User $user)
    {
        $this->job = $job;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('theclubhouse@generalsports.com', 'theClubhouse®')
                    ->subject('You have been assigned as a job owner - theClubhouse®')
                    ->markdown('emails.new-job-owner');
    }
}

