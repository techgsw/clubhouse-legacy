<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewClubhouseContentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $new_webinars;
    public $new_webinar_recordings;
    public $new_blog_posts;
    public $new_mentors;
    public $new_training_videos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,
                                $new_webinars,
                                $new_webinar_recordings,
                                $new_blog_posts,
                                $new_mentors,
                                $new_training_videos
    ) {
        $this->user = $user;
        $this->new_webinars = $new_webinars;
        $this->new_webinar_recordings = $new_webinar_recordings;
        $this->new_blog_posts = $new_blog_posts;
        $this->new_mentors = $new_mentors;
        $this->new_training_videos = $new_training_videos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('app@sportsbusiness.solutions', 'theClubhouse®')
            ->subject("See what's new in theClubhouse®")
            ->markdown('emails.new-clubhouse-content');
    }
}
