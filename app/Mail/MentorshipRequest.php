<?php

namespace App\Mail;

use App\Mentor;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MentorshipRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $dates;
    public $mentor;
    public $user;

    public function __construct(Mentor $mentor, User $user, array $dates)
    {
        $this->mentor = $mentor;
        $this->user = $user;
        $this->dates = $dates;
    }

    public function build()
    {
        return $this->from(__('email.support_address'))->markdown('emails.mentor.request');
    }
}
