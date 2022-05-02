<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ContactJob;

class ContactJobFollowup extends Mailable
{
    use Queueable, SerializesModels;

    public $contact_job;
    public $is_final;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactJob $contact_job, $is_final)
    {
        $this->contact_job = $contact_job;
        $this->is_final = $is_final;
        $this->user = \Auth::user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('theclubhouse@generalsports.com', 'theClubhouse®');
        if ($this->is_final) {
            $mail->subject("{$this->contact_job->job->organization_name}");
            return $mail->markdown('emails.contact.contact-job-followup-final');
        } else {
            $mail->subject("Last email from {$this->contact_job->job->organization_name}");
            return $mail->markdown('emails.contact.contact-job-followup');
        }
    }
}

