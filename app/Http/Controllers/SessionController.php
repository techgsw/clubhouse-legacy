<?php

namespace App\Http\Controllers;

use App\Session;
use App\Message;
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
    /**
     * @return \Illuminate\Http\Response
     */
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

    /**
     * @param  StoreSession $request
     * @return Response
     */
    public function store(StoreSession $request)
    {
        $this->authorize('create-post-session');

        try {
            $session = DB::transaction(function () {
                $session = Session::create([
                    'user_id' => Auth::user()->id,
                    'title' => request('title'),
                    'description' => request('description')
                ]);

                $image = request()->file('image_url');

                if ($image) {
                    $storage_path = storage_path().'/app/public/session/'.$session->id.'/';
                    $filename = $session->id.'-Sports-Business-Solutions.'.strtolower($image->getClientOriginalExtension());

                    $image_relative_path = $image->storeAs('session/'.$session->id, 'original-'.$filename, 'public');

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

                    $session_image = str_replace('original', 'medium', $image_relative_path);

                    $session->image_url =  $session_image;
                    $session->save();
                }

                return $session;
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $message = "Sorry, we were unable to create the session. Please contact support.";
            $request->session()->flash('message', new Message(
                $message,
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        return redirect()->action('ArchivesController@index');
    }

    /**
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $session = Session::find($id);
        if (!$session) {
            return redirect()->back()->withErrors(['msg' => 'Could not find session ' . $id]);
        }
        $this->authorize('edit-session', $session);

        $pd = new Parsedown();

        return view('session/edit', [
            'session' => $session,
            'title' => $pd->text($session->title),
            'description' => $pd->text($session->description),
            'breadcrumb' => [
                'Home' => '/',
                'Archives' => '/archives',
                "{$session->id}" => "/session/{$id}/edit"
            ]
        ]);
    }

    /**
     * @param  UpdateSession $request
     * @param  int $id
     * @return Response
     */
    public function update(UpdateSession $request, $id)
    {
        $session = Session::find($id);
        if (!$session) {
            return redirect()->back()->withErrors(['msg' => 'Could not find session ' . $id]);
        }
        $this->authorize('edit-session', $session);

        try {
            DB::transaction(function () use ($session) {
                $session->title = request('title');
                $session->description= request('description');
                $session->save();

                $image = request()->file('image_url');

                if ($image) {
                    $storage_path = storage_path().'/app/public/session/'.$session->id.'/';
                    $filename = $session->id.'-Sports-Business-Solutions.'.strtolower($image->getClientOriginalExtension());

                    $image_relative_path = $image->storeAs('session/'.$session->id, 'original-'.$filename, 'public');

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

                    $session_image = str_replace('original', 'medium', $image_relative_path);

                    $session->image_url =  $session_image;
                    $session->save();
                }
            });
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

        return redirect()->action('ArchivesController@index');
    }
}
