<?php

namespace App\Mail\Admin;

use App\ContactJob;
// use App\Inquiry;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class ContactWarmComm extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactJob $contact)
    {
        $this->contact = $contact;
        $this->user = Auth::user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from($this->user->email);
        $mail->subject("Your {$this->contact->job->title} job application status with the {$this->contact->job->organization_name}");

        return $mail->markdown('emails.contact.contact-warm-communication');
        
    }
}
