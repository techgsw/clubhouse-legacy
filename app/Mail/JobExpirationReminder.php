<?php

namespace App\Mail;

use App\Job;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobExpirationReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $job;
    public $user;
    public $number_of_days;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Job $job, User $user, int $number_of_days)
    {
        $this->job = $job;
        $this->user = $user;
        $this->number_of_days = $number_of_days;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@sportsbusiness.solutions')
            ->subject($this->job->title.' at '.$this->job->organization_name.' Expiring in '.$this->number_of_days.' days - theClubhouse®')
            ->markdown('emails.status.job-expiration-reminder');
    }
}

