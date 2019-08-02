<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ContactJob;

class ContactJobInterestRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $contact_job;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactJob $contact_job)
    {
        $this->contact_job = $contact_job;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@sportsbusiness.solutions')
                    ->markdown('emails.contact.job-interest-request');
    }
}
