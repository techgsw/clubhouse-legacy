<?php

namespace App\Providers;

use Mail;
use App\User;
use App\Mail\NewUserFollowUp;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class EmailServiceProvider extends ServiceProvider
{
    public static function sendNewUserFollowUpEmails(\DateTime $date)
    {
        $users = User::registeredOn($date);

        foreach ($users->get() as $user) {
            Mail::to($user)->send(new NewUserFollowUp($user));
        }
    }
}
