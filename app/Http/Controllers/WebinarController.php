<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\PurchaseNotification;
use App\Mail\CancelNotification;
use App\Mail\UserPaid;
use App\Mail\UserPaidClubhousePro;
use App\Mail\UserPaidCareerService;
use App\Mail\UserPaidWebinar;
use App\Message;
use App\Role;
use App\Transaction;
use App\TransactionProductOption;
use App\RoleUser;
use App\ProductOption;
use App\Http\Requests\StoreCheckout;
use App\Providers\StripeServiceProvider;
use App\Providers\EmailServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Parsedown;
use \Exception;

class WebinarController extends Controller
{
    public function index(Request $request, $id)
    {
    }

    public function store(StoreCheckout $request)
    {
        $user = Auth::user();

        try {
            $response = DB::transaction(function () use ($request, $user) {
                // dd($request);

                $checkout_type;
                if ($request['product_option_price'] > 0) {
                    if (preg_match('/sku/', $request['stripe_product_id'])) {
                        $order = StripeServiceProvider::purchaseSku($user, $request['payment_method'], $request['stripe_product_id']);
                        $product_option = ProductOption::with('product')->where('stripe_sku_id', $request['stripe_product_id'])->first();
    
                        try {
                            $product_option->quantity = $product_option->quantity - 1;
                            $product_option->save();
                        } catch (\Exception $e) {
                            Log::error($e->getMessage());
                        }
    
                        $transaction = new Transaction();
                        $transaction->user_id = $user->id;
                        $transaction->amount = $product_option->price;
                        if (!is_null($order->id)) {
                            $transaction->stripe_order_id = $order->id;
                        }
                        if (!is_null($order->charge)) {
                            $transaction->stripe_charge_id = $order->charge;
                        }
                        $transaction->save();
    
                        $transaction_product_option = new TransactionProductOption();
                        $transaction_product_option->transaction_id = $transaction->id;
                        $transaction_product_option->product_option_id = $product_option->id;
                        $transaction_product_option->save();
                    } else {
                        return false;
                    }
                }

                foreach ($product_option->product->tags as $tag) {
                    try {
                        EmailServiceProvider::sendWebinarPurchaseNotificationEmail($user, $product_option, 0, 'webinar');
                        Mail::to($user)->send(new UserPaidWebinar($user, $product_option));
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                    }
                    $checkout_type = 'webinar';
                    break;
                }


                return array('type' => $checkout_type, 'product_option_id' => $product_option->id);
            });
            
            if ($response == false) {
                return redirect()->back()->withErrors(['msg' => 'Invalid product.']);
            }
        } catch (Exception $e) {
            // TODO try to refund order if it went through
            // dd($e);
            Log::error($e);
            return redirect()->back()->withErrors(['msg' => 'We were unable to complete your transaction at this time.']);
        }

        return redirect()->action('WebinarController@thanks', $response);
    }

    public function thanks(Request $request)
    {
        $user = Auth::user();
        // dd($request);
        $product_option = ProductOption::with('product')->find($request['product_option_id']);
        // dd($product_option);
        $view = 'webinar-thanks';
        $breadcrumb = 'Webinar';
        $link = '/webinars';

        return view('checkout/'.$view, [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Checkout' => '',
                $breadcrumb => $link,
                'Thanks' => ''
            ],
            'product_option' => $product_option
        ]);
    }

    public function checkout(Request $request, $id)
    {
        
        $user = Auth::user();
        $product_option = ProductOption::with(['product' => function ($query) { $query->where('active', true); }])->find($id);
        
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

        if (!$product_option || !$product_option->product) {
            $request->session()->flash('message', new Message(
                "We were unable to find the product you were looking for.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return abort(404);
        }

        if (in_array('webinar', array_column($product_option->product->tags->toArray(), 'slug'))) {
            $product_type = 'webinar';
            $breadcrumb = array('name' => 'Educational Webinars', 'link' => '/webinars');
        }

        return view('checkout/index', [
            'product_option' => $product_option,
            'payment_methods' => (!is_null($stripe_user) && !is_null($stripe_user->sources) ? $stripe_user->sources->data : array()),
            'product_type' => $product_type,
            'product_price' => $product_option->price,
            'breadcrumb' => [
                'Clubhouse' => '/',
                $breadcrumb['name'] => $breadcrumb['link'],
                'Checkout' => null,
                "{$product_option->product->name}" => "{$breadcrumb['link']}/{$product_option->product->id}",
                "{$product_option->name}" => ""
            ]
        ]);
    }
}
