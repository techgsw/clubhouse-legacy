<?php

namespace App\Providers;

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
        \View::composer('layouts.components.instagram-feed', function ($view) {
            $this->getInstagramFeed($view);
        });
        // Don't load Twitter feed manually. Using embedded timeline.
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

    protected function getInstagramFeed($view) {
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
        $view->with([
            'username' => $username,
            'avatar' => $avatar,
            'bio' => $bio,
            'feed' => $feed,
        ]);
    }

    protected function getTwitterFeed($view) {
        // Get credentials
        $access_token = env('TWITTER_ACCESS_TOKEN');
        $screen_name = env('TWITTER_SCREEN_NAME');

        // Get user
        $url = "https://api.twitter.com/1.1/users/show.json?screen_name={$screen_name}";
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
            dd($e);
            curl_close($ch);
            return;
        }
        curl_close($ch);

        $profile_url = $data->url;
        $avatar = $data->profile_image_url_https;
        $bio = $data->description;

        // Get feed
        $count = 10;
        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json?count={$count}&screen_name={$screen_name}";
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
            dd($e);
            curl_close($ch);
            return;
        }
        curl_close($ch);

        // Process data
        $feed = [];
        foreach ($data as $tweet) {
            $feed[] = [
                "user" => [
                    "name" => $tweet->user->name,
                    "username" => $tweet->user->screen_name,
                    "url" => $tweet->user->url,
                    "profile_url" => $tweet->user->profile_image_url_https,
                ],
                "text" => $tweet->text,
                //"url" => $link,
            ];
        }

        // Send feed to view
        $view->with([
            "username" => $screen_name,
            "avatar" => $avatar,
            "bio" => $bio,
            "url" => $profile_url,
            "feed" => $feed,
        ]);
    }
}
