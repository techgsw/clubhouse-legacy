<?php

namespace App\Providers;

use App\Product;
use App\ProductOption;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;


class CURLServiceProvider extends ServiceProvider
{
    public static function sendPostRequest(string $path, array $data)
    {
        $request_url = env('ZOOM_API_URL') . $path;

        $post_fields = json_encode($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "authorization: Bearer " . env('ZOOM_JWT'),
            "content-type: application/json"
        ));

        $response = curl_exec($ch);
        
        curl_close($ch);

        if (!$response) {
            return false;
        }

        return json_decode($response);
    }

    public static function sendGetRequest(string $path, array $data = null, array $options = null)
    {
        $request_url = env('ZOOM_API_URL') . $path;

        // Append arguments to URL
        if ($data && $url[count($url)] != "?") {
            if ($url[count($url)] == "/") {
                // Drop closing "/"
                // e.g. https://google.com/ => https://google.com
                $url = substr($url, count($url)-1);
            }
            $url .= "?" . http_build_query($data);
        }

        $defaults = array(
            CURLOPT_URL => $request_url,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . env('ZOOM_JWT'),
                "content-type: application/json"
            )
        );

        if ($options) {
            $options = array_replace($defaults, $options);
        } else {
            $options = $defaults;
        }

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        if (!$response = curl_exec($ch)) {
            trigger_error(curl_error($ch));
        }
        curl_close($ch);

        return json_decode($response);
    }
}
