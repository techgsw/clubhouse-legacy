<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
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
    
    public static function getTweets($view, $context) {
        $access_token = env('TWITTER_ACCESS_TOKEN');
        $screen_name = env('TWITTER_SCREEN_NAME');

        // Get tweets
        // https://twitter.com/search?l=&q=%23sportsbiztip%20from%3ASportsBizSol&src=typd
        if ($context == 'sales-vault') {
            $url = "https://api.twitter.com/1.1/search/tweets.json?q=%23sportsalestips%20AND%20%2Dfilter%3Aretweets&count=15";
        } else if ($context == 'same-here') {
            $url = "https://api.twitter.com/1.1/search/tweets.json?q=%23sameheresolutions&count=5";
        } else {
            return null;
        }

        // Pull a list of all tweets, cached for 2 minutes
        $data = Cache::remember('twitter-feed-'.$context, 15, function() use ($url, $access_token) {
            $ch = curl_init($url);
            $headers = [
                "Authorization: Bearer {$access_token}",
                "Cache-Control: no-cache"
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
            return $data;
        });

        if (!$data->statuses || count($data->statuses) == 0) {
            return null;
        }

        $statuses = array();

        // Pull an embedded card for each tweet, cached for 1 week
        foreach ($data->statuses as $status) {
            $data = Cache::remember('twitter-status-'.$status->id, 10080, function() use ($status, $access_token) {
                $url = "https://publish.twitter.com/oembed?omit_script=true&url=https://twitter.com/Interior/status/" . $status->id;
                $ch = curl_init($url);
                $headers = [
                    "Authorization: Bearer {$access_token}",
                    "Cache-Control: no-cache"
                ];
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
                curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                try {
                    $data = curl_exec($ch);
                    $data = json_decode($data);
                } catch (\Exception $e) {
                    curl_close($ch);
                    return;
                }
                curl_close($ch);
                return $data;
            });

            if ($data && $data->html) {
                $statuses []= $data->html;
            }
        }

        // Send feed to view
        return $view->with([
            "feed" => $statuses,
        ]);
    }
}
