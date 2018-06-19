<?php

namespace App\Mail;

use App\Inquiry;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InquiryRated extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $rating;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Inquiry $inquiry, $rating)
    {
        $this->inquiry = $inquiry;
        $this->rating = $rating;
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
        switch ($this->rating) {
            case 'up':
                return $mail->markdown('emails.inquiry.rated-up');
            case 'maybe':
                return $mail->markdown('emails.inquiry.rated-maybe');
            case 'down':
                return $mail->markdown('emails.inquiry.rated-down');
        }
    }
}
