<?php

use App\Contact;
use App\Mail\ClubhouseFollowUp;
use App\Profile;
use App\User;

Route::get('/mwp', function () {
    collect([
        'entry_level_management' => 'management',
        'mid_level_management' => 'management',
    ])->each(function ($to, $from) {
        Contact::where('job_seeking_type', $from)
            ->each(function (Contact $contact) use ($to) {
                $contact->update(['job_seeking_type' => $to]);
            });
        Profile::where('job_seeking_type', $from)
            ->each(function (Profile $profile) use ($to) {
            $profile->update(['job_seeking_type' => $to]);
        });
    });
});
