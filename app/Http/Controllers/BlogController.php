<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
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
        $posts = Post::search($request)->where('post_type_code', 'blog')->paginate(15);
        $tags = Tag::has('posts')->orderBy('name', 'dec')->get();

        $tag = null;
        if ($request->tag) {
            $results = Tag::where('slug', $request->tag)->get();
            if (count($results) > 0) {
                $tag = $results[0];
            }
        }

        return view('blog/index', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Sports Industry Blog' => '/blog'
            ],
            'posts' => $posts,
            'tags' => $tags,
            'result_tag' => $tag
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
                'Clubhouse' => '/',
                'Sports Industry Blog' => '/blog',
                "$post->title" => "/post/{$post->id}"
            ]
        ]);
    }
}
