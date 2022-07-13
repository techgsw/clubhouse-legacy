<?php

use App\Mail\ClubhouseFollowUp;
use App\Providers\SocialMediaServiceProvider;
use App\User;

Route::get('/mwp', function () {
    $result = SocialMediaServiceProvider::getInstagramFeed(view('layouts.components.instagram-feed'), 'clubhouse');

    echo $result;
});
