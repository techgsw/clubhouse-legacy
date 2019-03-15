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

class ContactColdComm extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $rating;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactJob $contact, $rating)
    {
        $this->contact = $contact;
        $this->rating = $rating;
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
        return $mail->markdown('emails.contact.contact-cold-communication');
        
        // switch ($this->rating) {
        //     case 'active':
        //     case 'passive':
        //         return $mail->markdown('emails.inquiry.rated-passive-up');
        // }
    }
}
