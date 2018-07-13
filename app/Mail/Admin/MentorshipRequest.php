<?php

namespace App\Mail\Admin;

use App\Mentor;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MentorshipRequest extends Mailable
{
    use Queueable, SerializesModels;

    public $mentor;
    public $user;

    public function __construct(Mentor $mentor, User $user)
    {
        $this->mentor = $mentor;
        $this->user = $user;
    }

    public function build()
    {
        return $this->from('app@sportsbusiness.solutions')->markdown('emails.internal.mentor-request');
    }
}
