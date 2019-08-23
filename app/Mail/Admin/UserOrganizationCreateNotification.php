<?php

namespace App\Mail\Admin;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserOrganizationCreateNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $organization;

    public function __construct(User $user, $organization)
    {
        $this->user = $user;
        $this->organization = $organization;
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
            ->markdown('emails.internal.user-organization-create');
    }
}
