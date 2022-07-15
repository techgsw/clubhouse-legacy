<?php

use App\Mail\ClubhouseFollowUp;
use App\User;

Route::get('/mwp', function () {
    echo __('email.support_address');
});
