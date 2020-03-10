<?php

namespace App\Providers;

use App\Product;
use App\ProductOption;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;


class ZoomServiceProvider extends ServiceProvider
{
    public static function listUsers()
    {
        $path = 'users';

        return CURLServiceProvider::sendGetRequest($path);
    }

    public static function createWebinar(string $topic, string $description, \DateTime $start_time, $require_registration)
    {
        $path = 'users/' . env('ZOOM_USER_ID') . '/webinars';

        $data = array(
            'topic' => $topic,
            'agenda' => $description,
            'timezone' => 'America/Phoenix',
            'start_time' => $start_time->format('Y-m-d') . 'T' . $start_time->format('H:i:s'),
            //'password' => substr(uniqid(), 0, 10),
            'settings' => array(
                'approval_type' => $require_registration ? 0 : 2,
                'host_video' => true,
                'panelists_video' => true,
                'practice_session' => true,
                'close_registration' => true,
                'auto_recording' => 'cloud'
            )
        );

        return CURLServiceProvider::sendPostRequest($path, $data);
    }

    public static function addRegistrant(string $webinar_id,  User $user)
    {
        $path = '/webinars/' . $webinar_id . '/registrants';

        $data = array(
            'email' => $user->email,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name
        );
        
        return CURLServiceProvider::sendPostRequest($path, $data);
    }
}
