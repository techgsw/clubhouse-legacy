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

    public static function createWebinar(string $topic, \DateTime $start_time)
    {
        $path = 'users/' . env('ZOOM_USER_ID') . '/webinars';

        $data = array(
            'topic' => $topic,
            'timezone' => 'America/Phoenix',
            'start_time' => $start_time->format('Y-m-d') . 'T' . $start_time->format('H:i:s'),
            'password' => substr(uniqid(), 0, 10),
            'settings' => array(
                'approval_type' => 0,
                'host_video' => true,
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
