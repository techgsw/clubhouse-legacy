<?php

namespace App\Http\Controllers;

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

class CheckoutController extends Controller
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

        return view('checkout/index', [
            'breadcrumb' => [
                'Home' => '/',
                'Checkout' => '/checkout'
            ]
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
}
