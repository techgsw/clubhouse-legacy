<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SocialMediaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.components.twitter-sportsbiztip', function ($view) {
            SocialMediaServiceProvider::getTweets($view);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public static function getInstagramFeed($view) {
        $access_token = env('INSTAGRAM_ACCESS_TOKEN');
        $client_id = env('INSTAGRAM_CLIENT_ID');
        $user_id = env('INSTAGRAM_USER_ID');

        // Get user
        $url = "https://api.instagram.com/v1/users/self?access_token={$access_token}";
        try {
            $response = json_decode(file_get_contents($url));
        } catch (Exception $e) {
            // TODO log exception
            dd($e);
            return;
        }

        $username = $response->data->username;
        $avatar = $response->data->profile_picture;
        $bio = $response->data->bio;

        // Get feed
        $url = "https://api.instagram.com/v1/users/{$user_id}/media/recent/?access_token={$access_token}";
        try {
            $response = json_decode(file_get_contents($url));
        } catch (Exception $e) {
            // TODO log exception
            dd($e);
            return;
        }

        // Process data
        $feed = [];
        for ($i = 0; $i < 9; $i++) {
            $item = $response->data[$i];
            if (!$item) {
                break;
            }
            $image = $item->images->thumbnail->url;
            $link = $item->link;
            $feed[] = [
                "url" => $link,
                "src" => $image,
            ];
        }

        // Send feed to view
        return $view->with([
            'username' => $username,
            'avatar' => $avatar,
            'bio' => $bio,
            'feed' => $feed,
        ]);
    }

    protected function getTweets($view) {
        $access_token = env('TWITTER_ACCESS_TOKEN');
        $screen_name = env('TWITTER_SCREEN_NAME');

        // Get tweets
        $count = 3;
        $hashtag = 'sportsbiztip';
        $url = "https://api.twitter.com/1.1/search/tweets.json?q=from:{$screen_name}+%23{$hashtag}&count={$count}";
        $ch = curl_init($url);
        $headers = [
            "Authorization: Bearer {$access_token}",
        ];
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        try {
            $data = curl_exec($ch);
            $data = json_decode($data);
        } catch (Exception $e) {
            curl_close($ch);
            return;
        }
        curl_close($ch);

        if (!$data->statuses || count($data->statuses) == 0) {
            $view->with([
                "feed" => false,
            ]);
        }

        // Send feed to view
        $view->with([
            "screen_name" => $screen_name,
            "feed" => $data->statuses,
        ]);
    }
}
