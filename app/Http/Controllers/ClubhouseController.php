<?php

namespace App\Http\Controllers;

use App\Mentor;
use App\Post;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Parsedown;
use \Exception;

class ClubhouseController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::search($request)->where('post_type_code', 'blog')->limit(3)->get();

        $mentors = Mentor::with('contact')
            ->where('active', true)
            ->get();
        

        return view('clubhouse/index', [
            'posts' => $posts,
            'mentors' => $mentors
        ]);
    }
}
