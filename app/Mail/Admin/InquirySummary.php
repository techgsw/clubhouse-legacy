<?php

namespace App\Mail\Admin;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InquirySummary extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiries;
    public $jobs;
    public $start;
    public $end;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        \DateTime $start,
        \DateTime $end,
        $inquiries,
        $jobs
    ) {
        $this->start = $start;
        $this->end = $end;
        $this->inquiries = $inquiries;
        $this->jobs = $jobs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('app@sportsbusiness.solutions')
            ->markdown('emails.internal.inquiry-summary');
    }
}
