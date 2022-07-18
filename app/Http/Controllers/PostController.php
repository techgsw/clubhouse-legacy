<?php

namespace App\Http\Controllers;

use App\Image;
use App\Post;
use App\PostImage;
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

        $post_tags = json_decode(request('post_tags_json'));

        // TODO there is an unusual issue when uploading an extra image without a primary image. the primary image can't be reset when editing.
        //      to prevent this from happening, we'll throw an error if they try to create a post like this.
        if (is_null(request()->file('primary_image_url')) && !is_null(request('image'))) {
            $request->session()->flash('message', new Message(
                'Please upload a main image to create a new blog post.',
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        try {
            $title_url = DB::transaction(function () use ($post_tags) {
                $title_url = preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', mb_strtolower(request('title'))));
                $post = Post::create([
                    'user_id' => Auth::user()->id,
                    'authored_by' => request('authored_by'),
                    'title' => request('title'),
                    'title_url' => $title_url,
                    'body' => request('body')
                ]);

                if ($primary_image_url = request()->file('primary_image_url')) {
                    $primary_image = ImageServiceProvider::saveFileAsImage(
                        $primary_image_url,
                        $filename = preg_replace('/\s/', '-', str_replace("/", "", $post->title_url)).'-SportsBusinessSolutions',
                        $directory = 'post/'.$post->id,
                        $options = [ 'cropFromCenter' => true, 'landscape_share' => true ]
                    );
                    $post->images()->save($primary_image);
                    $post->images()->updateExistingPivot($primary_image->id, array(
                        'caption' => request('primary_image_caption'),
                        'alt' => request('primary_image_alt'),
                        'is_primary' => true
                    ));
                }

                if (!is_null(request('image'))) {
                    foreach (request('image') as $index => $image) {
                        $saved_image = null;
                        if (isset($image['url']) && $image_url = $image['url']) {
                            $saved_image = ImageServiceProvider::saveFileAsImage(
                                $image_url,
                                $filename = preg_replace('/\s/', '-', str_replace("/", "", $post->id . '-' . $index . '-' . $image['alt'])) . '-SportsBusinessSolutions',
                                $directory = 'post/' . $post->id,
                                $options = [
                                    'cropFromCenter' => true,
                                    'landscape_share' => true,
                                    'update' => ($image['id'] ? Image::find($image['id']) : null)
                                ]
                            );
                            $post->images()->save($saved_image);
                        }
                        if ($image_id = !is_null($saved_image) ? $saved_image->id : $image['id']) {
                            $post->images()->updateExistingPivot($image_id, array(
                                'caption' => $image['caption'],
                                'alt' => $image['alt'],
                                'is_primary' => false
                            ));
                            $post->body = preg_replace("/!\[$index\]\(([^)]*)\)/", "![" . $image['alt'] . "](" . (!is_null($saved_image) ? $saved_image->getURL() : "$1") . ")", $post->body);
                        }
                    }
                }

                $post->save();

                $post->tags()->sync($post_tags);

                return $title_url;
            });
        } catch (Exception $e) {
            Log::error($e);
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

        $post_tags = [];
        foreach ($post->tags as $tag) {
            $post_tags[] = $tag->name;
        }

        $pd = new Parsedown();

        return view('post/edit', [
            'post' => $post,
            'post_tags_json' => json_encode($post_tags),
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

        $post_tags = json_decode(request('post_tags_json'));

        try {
            DB::transaction(function () use ($post, $post_tags) {
                $post->title = request('title');
                $post->authored_by = request('authored_by');
                $post->title_url = preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', mb_strtolower(request('title'))));
                $post->body = request('body');

                if ($primary_image_url = request()->file('primary_image_url')) {
                    $primary_image = ImageServiceProvider::saveFileAsImage(
                        $primary_image_url,
                        $filename = preg_replace('/\s/', '-', str_replace("/", "", $post->title_url)).'-SportsBusinessSolutions',
                        $directory = 'post/'.$post->id,
                        $options = [
                            'cropFromCenter' => true,
                            'landscape_share' => true,
                            'update' => $post->getPrimaryImage()
                        ]
                    );
                    $post->images()->save($primary_image);
                }
                if (!is_null($post->images()) && !is_null($post->getPrimaryImage())) {
                    $post->images()->updateExistingPivot($post->getPrimaryImage()->id, array(
                        'caption' => request('primary_image_caption'),
                        'alt' => request('primary_image_alt'),
                        'is_primary' => true
                    ));
                }

                if (!is_null(request('image'))) {
                    foreach (request('image') as $index => $image) {
                        $saved_image = null;
                        if (isset($image['url']) && $image_url = $image['url']) {
                            $saved_image = ImageServiceProvider::saveFileAsImage(
                                $image_url,
                                $filename = preg_replace('/\s/', '-', str_replace("/", "", $post->id . '-' . $index . '-' . $image['alt'])) . '-SportsBusinessSolutions',
                                $directory = 'post/' . $post->id,
                                $options = [
                                    'cropFromCenter' => true,
                                    'landscape_share' => true,
                                    'update' => ($image['id'] ? Image::find($image['id']) : null)
                                ]
                            );
                            if (!$image['id']) {
                                $post->images()->save($saved_image);
                            }
                        }
                        if ($image_id = !is_null($saved_image) ? $saved_image->id : $image['id']) {
                            $post->images()->updateExistingPivot($image_id, array(
                                'caption' => $image['caption'],
                                'alt' => $image['alt'],
                                'is_primary' => false
                            ));
                            $post->body = preg_replace("/!\[$index\]\(([^)]*)\)/", "![" . $image['alt'] . "](" . (!is_null($saved_image) ? $saved_image->getURL() : "$1") . ")", $post->body);
                        }
                    }
                }

                $post->save();

                $post->tags()->sync($post_tags);
            });
        } catch (Exception $e) {
            Log::error($e);
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

    public function destroy($title_url)
    {
        $post = Post::where('title_url', $title_url)->first();
        if (!$post) {
            return redirect()->back()->withErrors(['msg' => 'Could not find post ' . $title_url]);
        }

        $post->images()->detach();
        $post->tags()->detach();
        $post->delete();

        return redirect()->action('BlogController@index');
    }
}
