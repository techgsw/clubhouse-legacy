<?php

namespace App\Http\Controllers;

use App\Post;
use App\Message;
use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
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
        // TODO title_url must be unique. like wordpress add numeric value at the end if it already exists, or fail out.

        try {
            $title_url = preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', mb_strtolower(request('title'))));
            $post = Post::create([
                'user_id' => Auth::user()->id,
                'title' => request('title'),
                'title_url' => $title_url,
                'body' => request('body')
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if ($e->getCode() === '23000') {
                $message = "Oops! It looks like you have already used that title!";
            } else {
                $message = "Sorry, we were unable to create the post. Please contact support.";
            }
            $request->session()->flash('message', new Message(
                $message,
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        return redirect()->action('BlogController@show', [$title_url]);
    }

    /**
     * @param  string $title_url
     * @return \Illuminate\Http\Response
     */
    public function edit($title_url)
    {
        $post = Post::where('title_url', $title_url)->first();
        if (!$post) {
            return redirect()->back()->withErrors(['msg' => 'Could not find post ' . $title_url]);
        }
        // TODO $this->authorize('edit-post', $post);

        $pd = new Parsedown();

        return view('post/edit', [
            'post' => $post,
            'body' => $pd->text($post->body),
            'breadcrumb' => [
                'Home' => '/',
                'Blog' => '/blog',
                'New Post' => "/post/{$title_url}/edit"
            ]
        ]);
    }

    /**
     * @param  UpdatePost  $request
     * @param  string $title_url
     * @return Response
     */
    public function update(UpdatePost $request, $title_url)
    {
        $post = Post::where('title_url', $title_url)->first();
        if (!$post) {
            return redirect()->back()->withErrors(['msg' => 'Could not find post ' . $title_url]);
        }
        // TODO $this->authorize('edit-post', $post);
        // TODO title_url must be unique. like wordpress add numeric value at the end if it already exists, or fail out.

        $post->title = request('title');
        $post->title_url = preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', mb_strtolower(request('title'))));
        $post->body = request('body');
        $post->save();

        return redirect()->action('BlogController@show', [$title_url]);
    }

    /**
     * @param  string $title_url
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $title_url)
    {
        return redirect()->action('BlogController@show', [$title_url]);
    }
}
