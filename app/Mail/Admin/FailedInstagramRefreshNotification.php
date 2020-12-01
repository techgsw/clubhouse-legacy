<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FailedInstagramRefreshNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $exception;
    public $env_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        $exception,
        $env_name
    ) {
        $this->exception = $exception;
        $this->env_name = $env_name;
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
            ->subject('Instagram Token Refresh Failed')
            ->markdown('emails.internal.failed-instagram-refresh');
    }
}

