<?php

namespace App\Mail;

use App\ContactJob;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class ContactDefaultComm extends Mailable
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
        $this->user = Auth::user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('app@sportsbusiness.solutions');
        $mail->subject("Your {$this->contact_job->job->title} job application status with the {$this->contact_job->job->organization_name}");

        return $mail->markdown('emails.contact.contact-default-communication');
    }
}
