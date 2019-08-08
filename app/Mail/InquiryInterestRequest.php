<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Inquiry;

class InquiryInterestRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
        $this->user = \Auth::user();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from('app@sportsbusiness.solutions');
        $mail->subject("Your {$this->inquiry->job->title} job application status with the {$this->inquiry->job->organization_name}");

        return $mail->markdown('emails.inquiry.inquiry-interest-request');
    }
}
