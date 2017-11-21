<?php

namespace App\Http\Controllers;

use App\Post;
use App\Message;
use App\Http\Requests\StorePost;
//use App\Http\Requests\UpdatePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Parsedown;
use \Exception;

class PostController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // TODO $this->authorize('create-post');

        return view('post/create', [
            'breadcrumb' => [
                'Home' => '/',
                'Blog' => '/blog',
                'New Post' => '/post/create'
            ]
        ]);
    }

    /**
     * @param  StorePost  $request
     * @return Response
     */
    public function store(StorePost $request)
    {
        // TODO $this->authorize('create-post');

        $post = Post::create([
            'user_id' => Auth::user()->id,
            'title' => request('title'),
            'body' => request('body')
        ]);

        return redirect()->action('PostController@show', [$post]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return abort(404);
        }

        $pd = new Parsedown();

        return view('post/show', [
            'title' => $post->title,
            'body' => $pd->text($post->body),
            'breadcrumb' => [
                'Home' => '/',
                'Blog' => '/blog',
                "$post->title" => "/post/{$post->id}"
            ]
        ]);
    }
}
