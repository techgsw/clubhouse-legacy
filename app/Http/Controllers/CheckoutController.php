<?php

namespace App\Http\Controllers;

use App\Message;
use App\ProductOption;
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
    public function index($id)
    {
        $product_option = ProductOption::with('product')->where('id', $id)->first();
        if (!$product_option) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        return view('checkout/index', [
            'product_option' => $product_option,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Checkout' => '/checkout',
                "{$product_option->product->name}" => "/product/{$product_option->product->id}",
                "{$product_option->name}" => ""
            ]
        ]);
    }
}
