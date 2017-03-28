<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('layouts.components.instagram-feed', function ($view) {
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

            $view->with([
                'username' => $username,
                'avatar' => $avatar,
                'bio' => $bio,
                'feed' => $feed,
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
