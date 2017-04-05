<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HubController extends Controller
{
    public function index()
    {
        // See https://github.com/vimeo/vimeo-oembed-examples/blob/master/oembed/php-example.php
        $oembed_endpoint = 'http://vimeo.com/api/oembed';
        // Grab the video url from the url, or use default
        $video_url = 'https://vimeo.com/211573270';
        // Create the URLs
        //$json_url = $oembed_endpoint . '.json?url=' . rawurlencode($video_url) . '&width=640';
        $xml_url = $oembed_endpoint . '.xml?url=' . rawurlencode($video_url) . '&width=640';
        // Curl helper function
        function curl_get($url) {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            $return = curl_exec($curl);
            curl_close($curl);
            return $return;
        }
        // Load in the oEmbed XML
        $oembed = simplexml_load_string(curl_get($xml_url));
        $video = html_entity_decode($oembed->html);

        return view('the-hub', [
            'video' => $video,
            'oembed' => $oembed,
        ]);
    }
}
