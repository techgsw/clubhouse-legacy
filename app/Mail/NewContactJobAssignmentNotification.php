<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\ContactJob;
use App\Job;
use App\User;

class NewContactJobAssignmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $job;
    public $contact_job;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Job $job, ContactJob $contact_job, User $user)
    {
        $this->job = $job;
        $this->contact_job = $contact_job;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('clubhouse@sportsbusiness.solutions', 'theClubhouse®')
                    ->subject("A new candidate has been assigned to your job posting - theClubhouse®")
                    ->markdown('emails.new-job-contact-assignment');
    }
}
