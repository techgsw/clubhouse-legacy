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
        // TODO: We can't pull bio and avatar without getting approval as an instagram app to use the instagram graph API.
        //  This information will be static until we can support that.
        if ($context == 'clubhouse') {
            $username = 'theC1ubhouse';
            $bio = "For current & aspiring #sportsbiz professionals. Learn, network, find career opportunities & share best practices in an effort to grow your career.";
            $avatar = env('CLUBHOUSE_URL').'/images/clubhouse_ig_logo.jpg';
        } else {
            $username = 'sportsbizsol';
            $bio = "We offer sales training, consulting and recruiting services for sports teams and properties throughout the US and Canada. Est. 2014";
            $avatar = env('APP_URL').'/images/sbs_ig_logo.jpg';
        }
        // Get feed
        $url = "https://graph.instagram.com/me/media/?fields=media_url,permalink&access_token={$access_token}";
        try {
            // We get rate limited by instagram's Basic Display API. Limiting to one minute per call
            $response = Cache::remember('insta-'.$context, 5, function() use ($url) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $curl_resp = json_decode(curl_exec($ch));
                if ($curl_resp->error) {
                    throw new \Exception(json_encode($curl_resp->error));
                }
                curl_close($ch);

                return $curl_resp;
            });

            // Process data
            $feed = [];
            $post_count = count($response->data);
            if ($post_count > 0) {
                if (!isset($limit) || is_null($limit)) {
                    $limit = ($post_count > 2 ? 3 : $post_count);
                }
                for ($i = 0; $i < $limit; $i++) {
                    $item = $response->data[$i];
                    if (!$item) {
                        break;
                    }
                    $image = $item->media_url;
                    $link = $item->permalink;
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
        } catch (\Exception $e) {
            Log::error($e);
            return;
        }
    }

    public static function refreshInstagramToken($access_token, $env_name) {
        try {
            $query_params = http_build_query(array(
                'grant_type' => 'ig_refresh_token',
                'access_token' => $access_token
            ));

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://graph.instagram.com/refresh_access_token?$query_params");
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $curl_resp = curl_exec($ch);
            $json_resp = json_decode($curl_resp);
            if ($json_resp->error) {
                throw new \Exception(json_encode($json_resp->error, JSON_PRETTY_PRINT));
            }
            curl_close($ch);

            $new_access_token = $json_resp->access_token;

            $env_file = base_path('.env');
            if (file_exists($env_file)) {
                $env_file_contents = file_get_contents($env_file);
                $modified_env_file_contents = str_replace(
                    $env_name.'='.$access_token,
                    $env_name.'='.$new_access_token,
                    $env_file_contents
                );
                file_put_contents($env_file, $modified_env_file_contents);
            } else {
                throw new \Exception('File '.$env_file.' could not be found');
            }
        } catch (\Throwable $t) {
            Log::error($t);
            EmailServiceProvider::sendFailedInstagramRefreshNotification($t, $env_name);
        }
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
