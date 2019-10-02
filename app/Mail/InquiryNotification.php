<?php

namespace App\Mail;

use App\Job;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InquiryNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $job;
    public $inquiry_user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Job $job, User $inquiry_user)
    {
        $this->job = $job;
        $this->inquiry_user = $inquiry_user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@sportsbusiness.solutions')
                    ->subject('New Candidate Application for '.$this->job->title.' - theClubhouse')
                    ->markdown('emails.inquiry.notification');
    }
}
