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
        //
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

    public static function getVimeoVideo($video_url) {
        // See https://github.com/vimeo/vimeo-oembed-examples/blob/master/oembed/php-example.php
        $oembed_endpoint = 'http://vimeo.com/api/oembed';
        $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url) . '&width=640';
        $oembed = simplexml_load_string(AppServiceProvider::curlGET($xml_url));
        return html_entity_decode($oembed->html);
    }

    public static function getRecentBlogPosts($count) {
        if (!$count || $count <= 0) {
            $count = 3;
        }
        $url = env("WP_API") . "/posts?per_page={$count}";

        $posts = AppServiceProvider::curlGET($url);
        if ($posts) {
            try {
                $posts = json_decode($posts);
            } catch (Exception $e) {
                \App\Exceptions\Handler::report($exception);
                return [];
            }
        }

        if (count($posts) > 0) {
            foreach ($posts as $i => $post) {
                $url = env("WP_API") . "/media?parent={$post->id}";
                $media = AppServiceProvider::curlGET($url);
                if ($media) {
                    try {
                        $media = json_decode($media)[0];
                    } catch (Exception $e) {
                        \App\Exceptions\Handler::report($exception);
                        return [];
                    }
                    $posts[$i]->image_url = $media->source_url;
                }
            }
        }

        return $posts;
    }

    protected static function curlGET($url) {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $return = curl_exec($curl);
        curl_close($curl);
        return $return;
    }
}
