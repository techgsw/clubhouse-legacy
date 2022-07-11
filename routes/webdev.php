<?php

use App\Mail\ClubhouseFollowUp;
use App\User;

Route::get('/mwp', function () {
   $user = User::find(1);

   $mailer = new ClubhouseFollowUp($user, 'connected');
   $mailer->build();
});
