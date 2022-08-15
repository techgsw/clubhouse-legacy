<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MonthlyMentorReport extends Mailable
{
    use Queueable, SerializesModels;

    public $mentors;
    public $mentees;
    public $total_requests;
    public $days_since;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mentors, $mentees, $total_requests, $days_since)
    {
        $this->mentors = $mentors;
        $this->mentees = $mentees;
        $this->total_requests = $total_requests;
        $this->days_since = $days_since;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(__('email.support_address'))
            ->subject('Mentorship Report - theClubhouse®')
            ->markdown('emails.internal.mentor-report');
    }
}

