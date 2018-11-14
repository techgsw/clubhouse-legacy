<?php

namespace App\Http\Controllers;

use App\Providers\SocialMediaServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialMediaController extends Controller
{

    public function instagram(Request $request)
    {
        if (preg_match('/clubhouse/', $request->url())) {
            return SocialMediaServiceProvider::getInstagramFeed(view('layouts.components.instagram-feed'), 'clubhouse');
        } else {
            return SocialMediaServiceProvider::getInstagramFeed(view('layouts.components.instagram-feed'));
        }
    }
}
