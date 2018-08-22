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
    public function index()
    {
        return view('checkout/index', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Checkout' => '/checkout'
            ]
        ]);
    }
}
