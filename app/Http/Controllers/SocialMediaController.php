<?php

namespace App\Http\Controllers;

use App\Providers\SocialMediaServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaController extends Controller
{

    public function twitter(Request $request)
    {
        return SocialMediaServiceProvider::getTweets(view('layouts.components.twitter-hashtag-feed'), $request->get('context'));
    }
}
