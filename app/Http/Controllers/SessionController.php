<?php

namespace App\Http\Controllers;

use App\Image;
use App\Message;
use App\Post;
use App\PostImage;
use App\Http\Requests\StoreSession;
use App\Http\Requests\UpdateSession;
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

class SessionController extends Controller
{
    public function create()
    {
        $this->authorize('create-post-session');

        return view('session/create', [
            'breadcrumb' => [
                'Home' => '/',
                'Archives' => '/archives',
                'New Session' => '/session/create'
            ]
        ]);
    }

    public function index()
    {
        $this->authorize('create-post-session');

        $posts = Post::where('post_type_code', 'session')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('session/index', [
            'breadcrumb' => [
                'Home' => '/',
                'Archives' => '/session'
            ],
            'posts' => $posts
        ]);
    }

    public function store(StoreSession $request)
    {
        $this->authorize('create-post-session');

        $response = new Message(
            "Success! New session created.",
            "success",
            $code = 200,
            $icon = "check_circle"
        );

        try {
            $post = DB::transaction(function () {
                $title_url = preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', mb_strtolower(request('title'))));
                $post = Post::create([
                    'user_id' => Auth::user()->id,
                    'authored_by' => request('authored_by'),
                    'title' => request('title'),
                    'title_url' => $title_url,
                    'body' => request('body') ?: request('title'),
                    'post_type_code' => 'session'
                ]);
                $post = Post::find($post->id);

                $image_list = request('image_list');
                if (is_array($image_list)) {
                    $dir = 'post/'.$post->id;
                    if (!Storage::exists("public/{$dir}")) {
                        Storage::makeDirectory("public/{$dir}");
                    }
                    $images = [];
                    foreach ($image_list as $index => $image) {
                        if ($image) {
                            $image = ImageServiceProvider::saveFileAsImage(
                                $image,
                                $filename = $index.time().'-'.$title_url.'-SportsBusinessSolutions',
                                $directory = 'post/'.$post->id,
                                $options = [ 'cropFromCenter' => true ]
                            );
                            $images[] = $image;
                        }
                    }
                }
                $post->images()->saveMany($images);

                return $post;
            });
            $response->setUrl('/session/'.$post->id.'/edit');
            $request->session()->flash('message', $response);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response->setMessage("Sorry, we were unable to create the session. Please contact support.");
            $response->setType("danger");
            $response->setCode(500);
        }

        return response()->json($response->toArray());
    }

    public function edit($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->back()->withErrors(['msg' => 'Could not find session ' . $id]);
        }
        $this->authorize('edit-post-session', $post);

        $pd = new Parsedown();

        return view('session/edit', [
            'post' => $post,
            'title' => $pd->text($post->title),
            'body' => $pd->text($post->body),
            'breadcrumb' => [
                'Home' => '/',
                'Archives' => '/session',
                "{$post->id}" => "/session/{$id}/edit"
            ]
        ]);
    }

    public function update(UpdateSession $request, $id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->back()->withErrors(['msg' => 'Could not find session ' . $id]);
        }
        $this->authorize('edit-post-session', $post);

        try {
            DB::transaction(function () use ($post) {
                $post->title = request('title');
                $post->body = request('body');
                $post->save();
            });
            $request->session()->flash('message', new Message(
                "Session updated!",
                "success",
                $code = null,
                $icon = "check_circle"
            ));
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $message = "Sorry, we were unable to edit the session. Please contact support.";
            $request->session()->flash('message', new Message(
                $message,
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        return redirect()->action('SessionController@edit', array($id));
    }

    public function imageOrder($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return redirect()->back()->withErrors(['msg' => 'Could not find session ' . $id]);
        }
        $this->authorize('edit-post-session', $post);

        $image_order = request('image_order');
        $response = new Message(
            "Success! Image order updated.",
            "success",
            $code = 200,
            $icon = "check_circle"
        );

        $images = $post->images;
        $image_map = [];
        foreach ($images as $image) {
            $image_map[$image->id] = $image;
        }

        for ($i = 0; $i < count($image_order); $i++) {
            try {
                $image = $image_map[$image_order[$i]];
                $image->order = $i+1;
                $image->save();
            } catch (Exception $e) {
                Log::error($e->getMessage());
                $response->setMessage("Sorry, we were unable to update the image order.");
                $response->setType("danger");
                $response->setCode(500);
            }
        }

        return response()->json($response->toArray());
    }
}
