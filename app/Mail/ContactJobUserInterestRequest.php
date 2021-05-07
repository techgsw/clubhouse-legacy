<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ContactJob;

class ContactJobUserInterestRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $contact_job;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactJob $contact_job)
    {
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
        $mail = $this->from('clubhouse@sportsbusiness.solutions', 'theClubhouse®');
        $mail->subject("A conversation with {$this->contact_job->job->organization_name}");

        return $mail->markdown('emails.contact.contact-job-user-interest-request');
    }
}
