<?php

namespace App\Http\Controllers;

use App\Message;
use App\ProductOption;
use App\Http\Requests\StoreCheckout;
use App\Providers\StripeServiceProvider;
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
    public function index(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->stripe_customer_id) {
            try {
                $stripe_user = StripeServiceProvider::createCustomer($user);
                $user->stripe_customer_id = $stripe_user->id;
                $user->update();
            } catch (Exception $e) {
                Log::error($e);
                $request->session()->flash('message', new Message(
                    "We are sorry. Currently we are unable to complete your customer profile.",
                    "danger",
                    $code = null,
                    $icon = "error"
                ));
            }
        } else {
            try {
                $stripe_user = StripeServiceProvider::getCustomer($user);
            } catch (Exception $e) {
                Log::error($e);
                return redirect()->back()->withErrors(['msg' => 'We are sorry. Currently, we are unable to retrieve your payment profile.']);
            }
        }

        $product_option = ProductOption::with(['product' => function ($query) { $query->where('active', true); }])->find($id);
        if (!$product_option || !$product_option->product) {
            $request->session()->flash('message', new Message(
                "We were unable to find the product you were looking for.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return abort(404);
        }

        return view('checkout/index', [
            'product_option' => $product_option,
            'payment_methods' => (!is_null($stripe_user) && !is_null($stripe_user->sources) ? $stripe_user->sources->data : array()),
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Checkout' => '/checkout',
                "{$product_option->product->name}" => "/product/{$product_option->product->id}",
                "{$product_option->name}" => ""
            ]
        ]);
    }

    public function store(StoreCheckout $request)
    {
        $user = Auth::user();

        try {
            if (preg_match('/sku/', $request['stripe_product_id'])) {
                $order = StripeServiceProvider::purchaseSku($user, $request['payment_method'], $request['stripe_product_id']);
            } else if (preg_match('/plan/', $request['stripe_product_id'])) {
                $plan = StripeServiceProvider::purchasePlan($user, $request['payment_method'], $request['stripe_product_id']);
            } else {
                return redirect()->back()->withErrors(['msg' => 'Invalid product.']);
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['msg' => 'We were unable to complete your transaction at this time.']);
        }


        return redirect()->action('CheckoutController@thanks');
    }

    public function addCard(Request $request)
    {
        $user = Auth::user();

        try {
            $stripe_customer = StripeServiceProvider::getCustomer($user);
            $stripe_customer->sources->create(array('source' => $request['stripe_token']));
            $stripe_customer = StripeServiceProvider::getCustomer($user);
        } Catch (Exception $e) {
            Log::error($e);
        }

        return response()->json([
            'type' => 'success',
            'payment_methods' => $stripe_customer->sources->data
        ]);
    }

    public function thanks(Request $request)
    {
        $user = Auth::user();

        return view('checkout/thanks', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Checkout' => '/checkout',
                'Thanks' => ''
            ]
        ]);
    }
}
