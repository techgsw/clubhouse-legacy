<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ContactJob;
use App\Job;

class NewContactJobResponseNotification extends Mailable
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
    public function __construct(Job $job, ContactJob $contact_job)
    {
        $this->job = $job;
        $this->contact_job = $contact_job;
        $this->user = \Auth::user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('clubhouse@sportsbusiness.solutions', 'theClubhouse®')
                    ->subject("A candidate has responded to your job posting - theClubhouse®")
                    ->markdown('emails.new-job-contact-response');
    }
}

