<?php

namespace App\Http\Controllers;

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

class BlogController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::paginate(15);

        return view('blog/index', [
            'breadcrumb' => [
                'Home' => '/',
                'Blog' => '/blog'
            ],
            'posts' => $posts
        ]);
    }

    /**
     * @param  string $title_url
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $title_url)
    {
        $post = Post::where('title_url', $title_url)->first();
        if (!$post) {
            return abort(404);
        }

        $pd = new Parsedown();

        return view('post/show', [
            'post' => $post,
            'body' => $pd->text($post->body),
            'breadcrumb' => [
                'Home' => '/',
                'Blog' => '/blog',
                "$post->title" => "/post/{$post->id}"
            ]
        ]);
    }
}
