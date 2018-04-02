<?php

namespace App\Http\Controllers;

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
        $posts = Post::where('post_type_code', 'session')->paginate(15);

        return view('session/index', [
            'breadcrumb' => [
                'Home' => '/',
                'Archives' => '/archives'
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
            $icon = "success"
        );

        try {
            $post = DB::transaction(function () {
                $title_url = preg_replace('/\s/', '-', preg_replace('/[^\w\s]/', '', mb_strtolower(request('title'))));
                $post = Post::create([
                    'user_id' => Auth::user()->id,
                    'authored_by' => request('authored_by'),
                    'title' => request('title'),
                    'title_url' => $title_url,
                    'body' => request('body'),
                    'post_type_code' => 'session'
                ]);

                $image_list = request('image_list');

                if (is_array($image_list)) {
                    foreach ($image_list as $index => $image) {
                        if ($image) {
                            $storage_path = storage_path().'/app/public/post/'.$post->id.'/';
                            $filename = $index.time().'-'.$title_url.'-Sports-Business-Solutions.'.strtolower($image->getClientOriginalExtension());

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

                            $width = $medium_image->getCurrentWidth();
                            $height = $medium_image->getCurrentHeight();
                            $dest_x = (1000-$width)/2;
                            $dest_y = (520-$height)/2;

                            $background_fill_image = imagecreatetruecolor(1000, 520);
                            $white_color = imagecolorallocate($background_fill_image, 255, 255, 255);
                            imagefill($background_fill_image, 0, 0, $white_color);
                            imagecopy($background_fill_image, $medium_image->getNewImage(), $dest_x, $dest_y, 0, 0, $width, $height);
                            imagejpeg($background_fill_image, $storage_path.'share-'.$filename, 100);

                            $post_image = new PostImage();
                            $post_image->post_id = $post->id;
                            $post_image->filename = $filename;
                            $post_image->image_order = $index + 1;

                            $post_image->save();
                        }
                    }
                }

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
                'Archives' => '/archives',
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
}
