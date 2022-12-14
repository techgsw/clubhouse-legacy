<?php

namespace App\Http\Controllers;

use App\Message;
use App\Post;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Parsedown;
use \Exception;

class ArchivesController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sessions = Post::where('post_type_code', 'session')->orderby('id', 'desc')->paginate(60);

        return view('archives/index', [ 'sessions' => $sessions, ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-post-session');

        return view('archive/create', [
            'breadcrumb' => [
                'Home' => '/',
                'Archive' => '/archive',
                'New Archive' => '/archive/create'
            ]
        ]);
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
