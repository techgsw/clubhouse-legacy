<?php

namespace App\Http\Controllers;

use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HubController extends Controller
{
    public function index()
    {
        $video_url = 'https://vimeo.com/211573270';

        return view('the-hub', [
            'video' => AppServiceProvider::getVimeoVideo($video_url),
            'posts' => AppServiceProvider::getRecentBlogPosts(3),
        ]);
    }
}
