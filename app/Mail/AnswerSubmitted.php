<?php

namespace App\Mail;

use App\Answer;
use App\Question;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnswerSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $answer;
    public $question;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Answer $answer, Question $question)
    {
        $this->answer = $answer;
        $this->question = $question;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(__('email.support_address'))
                    ->markdown('emails.answer.submitted');
    }
}
