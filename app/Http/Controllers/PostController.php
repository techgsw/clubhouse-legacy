<?php

namespace App\Http\Controllers;

use App\Post;
use App\Message;
use App\Http\Requests\StorePost;
use App\Http\Requests\UpdatePost;
use App\Providers\ImageServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $this->authorize('create-post');

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
        $this->authorize('create-post');
        // TODO title_url must be unique. like wordpress add numeric value at the end if it already exists, or fail out.

        try {
            $title_url = DB::transaction(function () {
                $title_url = preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', mb_strtolower(request('title'))));
                $post = Post::create([
                    'user_id' => Auth::user()->id,
                    'authored_by' => request('authored_by'),
                    'title' => request('title'),
                    'title_url' => $title_url,
                    'body' => request('body')
                ]);

                $image = request()->file('image_url');

                if ($image) {
                    $storage_path = storage_path().'/app/public/post/'.$post->id.'/';
                    $filename = $post->title_url.'-Sports-Business-Solutions.'.strtolower($image->getClientOriginalExtension());

                    $image_relative_path = $image->storeAs('post/'.$post->id, 'original-'.$filename, 'public');

                    $main_image = new ImageServiceProvider(storage_path().'/app/public/'.$image_relative_path);
                    $main_image->cropFromCenter(2000);
                    $main_image->save($storage_path.'/main-'.$filename);

                    $large_image = new ImageServiceProvider($storage_path.'/main-'.$filename);
                    $large_image->resize(1000, 1000);
                    $large_image->save($storage_path.'/large-'.$filename);

                    $medium_image = new ImageServiceProvider($storage_path.'/main-'.$filename);
                    $medium_image->resize(500, 500);
                    $medium_image->save($storage_path.'/medium-'.$filename);

                    $small_image = new ImageServiceProvider($storage_path.'/main-'.$filename);
                    $small_image->resize(250, 250);
                    $small_image->save($storage_path.'/small-'.$filename);

                    $post_image = str_replace('original', 'medium', $image_relative_path);

                    $post->image_url =  $post_image;
                    $post->save();
                }

                return $title_url;
            });
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
        $this->authorize('edit-post', $post);

        $pd = new Parsedown();

        return view('post/edit', [
            'post' => $post,
            'body' => $pd->text($post->body),
            'breadcrumb' => [
                'Home' => '/',
                'Blog' => '/blog',
                "{$post->title}" => "/post/{$title_url}/edit"
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
        $this->authorize('edit-post', $post);
        // TODO title_url must be unique. like wordpress add numeric value at the end if it already exists, or fail out.

        try {
            DB::transaction(function () use ($post) {
                $post->title = request('title');
                $post->authored_by = request('authored_by');
                $post->title_url = preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', mb_strtolower(request('title'))));
                $post->body = request('body');
                $post->save();

                $image = request()->file('image_url');

                if ($image) {
                    $storage_path = storage_path().'/app/public/post/'.$post->id.'/';
                    $filename = $post->title_url.'-Sports-Business-Solutions.'.strtolower($image->getClientOriginalExtension());

                    $image_relative_path = $image->storeAs('post/'.$post->id, 'original-'.$filename, 'public');

                    $main_image = new ImageServiceProvider(storage_path().'/app/public/'.$image_relative_path);
                    $main_image->cropFromCenter(2000);
                    $main_image->save($storage_path.'/main-'.$filename);

                    $large_image = new ImageServiceProvider($storage_path.'/main-'.$filename);
                    $large_image->resize(1000, 1000);
                    $large_image->save($storage_path.'/large-'.$filename);

                    $medium_image = new ImageServiceProvider($storage_path.'/main-'.$filename);
                    $medium_image->resize(500, 500);
                    $medium_image->save($storage_path.'/medium-'.$filename);

                    $small_image = new ImageServiceProvider($storage_path.'/main-'.$filename);
                    $small_image->resize(250, 250);
                    $small_image->save($storage_path.'/small-'.$filename);

                    $post_image = str_replace('original', 'medium', $image_relative_path);

                    $post->image_url =  $post_image;
                    $post->save();
                }
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if ($e->getCode() === '23000') {
                $message = "Oops! It looks like you have already used that title!";
            } else {
                $message = "Sorry, we were unable to edit the post. Please contact support.";
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
    public function show(Request $request, $title_url)
    {
        return redirect()->action('BlogController@show', [$title_url]);
    }
}
