<?php

namespace App\Mail;

use App\Inquiry;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class InquiryContacted extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $action;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inquiry $inquiry, $action)
    {
        $this->inquiry = $inquiry;
        $this->action = $action;
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
        $mail->subject("Your {$this->inquiry->job->title} job application status with the {$this->inquiry->job->organization_name}");
        switch ($this->action) {
            case 'active-positive':
                return $mail->markdown('emails.inquiry.contacted-active-positive');
            case 'active-maybe':
                return $mail->markdown('emails.inquiry.contacted-active-maybe');
            case 'active-negative':
                return $mail->markdown('emails.inquiry.contacted-active-negative');
            case 'passive-positive':
                return $mail->markdown('emails.inquiry.contacted-passive-positive');
            case 'passive-maybe':
                return $mail->markdown('emails.inquiry.contacted-passive-maybe');
            case 'passive-negative':
                return $mail->markdown('emails.inquiry.contacted-passive-negative');
        }
    }
}
