<?php

namespace App\Providers;

use App\Product;
use App\ProductOption;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;


class ZoomServiceProvider extends ServiceProvider
{
    private static function sendRequest(string $path, array $data)
    {
        $request_url = env('ZOOM_API_URL') . $path;

        $post_fields = http_build_query($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "authorization: Bearer " . env('ZOOM_JWT'),
            "content-type: application/json"
        ));
        curl_setopt($ch, CURLOPT_URL, $request_url);

        $response = curl_exec($ch);
        die($response);
        
        curl_close($ch);

        if(!$response){
            return false;
        }

        return json_decode($response);
    }

    public static function createWebinar(string $topic, \DateTime $start_time)
    {
        $path = 'webinar/create';

        $data = array(
            'timezone' => 'America/Phoenix',
            'start_time' => $start_time->format('YYYY-mm-dd h:i:s')
        );

        dd(ZoomServiceProvider::sendRequest($path, $data));

        return $this->sendRequest($path, $data);
    }
}
