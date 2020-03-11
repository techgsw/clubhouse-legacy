<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

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
            SocialMediaServiceProvider::getTweets($view, 'sportsbiztip');
        });
    }

    public static function getInstagramFeed($view, $context = null) {
        if ($context == 'clubhouse') {
            $access_token = env('CLUBHOUSE_INSTAGRAM_ACCESS_TOKEN');
            $client_id = env('CLUBHOUSE_INSTAGRAM_CLIENT_ID');
            $user_id = env('CLUBHOUSE_INSTAGRAM_USER_ID');
        } else if ($context == 'same-here') {
            $access_token = env('SAMEHERE_INSTAGRAM_ACCESS_TOKEN');
            $client_id = env('SAMEHERE_INSTAGRAM_CLIENT_ID');
            $user_id = env('SAMEHERE_INSTAGRAM_USER_ID');
            $limit = 5;
        } else {
            $access_token = env('INSTAGRAM_ACCESS_TOKEN');
            $client_id = env('INSTAGRAM_CLIENT_ID');
            $user_id = env('INSTAGRAM_USER_ID');
        }

        // Get user
        $url = "https://api.instagram.com/v1/users/self?access_token={$access_token}";
        try {
            $response = json_decode(file_get_contents($url));
        } catch (\Exception $e) {
            Log::error($e);
            return;
        }

        $username = $response->data->username;
        $avatar = $response->data->profile_picture;
        $bio = $response->data->bio;

        // Get feed
        $url = "https://api.instagram.com/v1/users/{$user_id}/media/recent/?access_token={$access_token}";
        try {
            $response = json_decode(file_get_contents($url));
        } catch (\Exception $e) {
            Log::error($e);
            return;
        }

        // Process data
        $feed = [];
        $post_count = count($response->data);
        if ($post_count > 0) {
            if (!isset($limit) || is_null($limit)) {
                $limit = ($post_count > 8 ? 9 : $post_count);
            }
            for ($i = 0; $i < $limit; $i++) {
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
        }

        // Send feed to view
        return $view->with([
            'username' => $username,
            'avatar' => $avatar,
            'bio' => $bio,
            'feed' => $feed,
        ]);
    }

    public static function getTweets($view, $context) {
        $access_token = env('TWITTER_ACCESS_TOKEN');
        $screen_name = env('TWITTER_SCREEN_NAME');

        // Get tweets
        // https://twitter.com/search?l=&q=%23sportsbiztip%20from%3ASportsBizSol&src=typd
        $count = 3;
        if ($context == 'sportsbiztip') {
            $url = "https://api.twitter.com/1.1/search/tweets.json?q=%23sportsbiztip%20from%3A{$screen_name}";
        } else if ($context == 'same-here') {
            $url = "https://api.twitter.com/1.1/search/tweets.json?q=%23sameheresolutions&count=5";
        } else {
            return null;
        }
        $ch = curl_init($url);
        $headers = [
            "Authorization: Bearer {$access_token}",
        ];
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        try {
            $data = curl_exec($ch);
            $data = json_decode($data);
        } catch (\Exception $e) {
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
        if ($context == 'sportsbiztip') {
            $view->with([
                "screen_name" => $screen_name,
                "feed" => $data->statuses,
            ]);
        } else if ($context == 'same-here') {
            return $view->with([
                "feed" => $data->statuses,
            ]);
        }
    }
}
