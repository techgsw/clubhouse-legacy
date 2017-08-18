<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BobAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $job;
    public $question;
    public $user;
    public $view;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $view, array $fields)
    {
        $this->view = $view;

        foreach ($fields as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@sportsbusiness.solutions')
                    ->markdown($this->view);
    }
}
