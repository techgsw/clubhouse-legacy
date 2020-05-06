<?php

namespace App\Http\Controllers;

use App\Providers\SocialMediaServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaController extends Controller
{

    public function instagram(Request $request)
    {
        if ($request->get('is_same_here') == 'true') {
            return SocialMediaServiceProvider::getInstagramFeed(view('layouts.components.same-here-instagram-feed'), 'same-here');
        } else if (preg_match('/clubhouse/', $request->url())) {
            return SocialMediaServiceProvider::getInstagramFeed(view('layouts.components.instagram-feed'), 'clubhouse');
        } else {
            return SocialMediaServiceProvider::getInstagramFeed(view('layouts.components.instagram-feed'));
        }
    }

    public function twitter(Request $request)
    {
        return SocialMediaServiceProvider::getTweets(view('layouts.components.twitter-hashtag-feed'), $request->get('context'));
    }
}
