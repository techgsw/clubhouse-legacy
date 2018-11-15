<?php

namespace App\Http\Controllers;

use Mail;
use App\Mail\UserPaid;
use App\Mail\UserPaidClubhousePro;
use App\Mail\UserPaidCareerService;
use App\Mail\UserPaidWebinar;
use App\Message;
use App\Role;
use App\RoleUser;
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

        if (!is_null($product_option->stripe_plan_id) && $user->can('view-clubhouse')) {
            return redirect()->back()->withErrors(['msg' => 'You are already a Clubhouse Pro member!']);
        }

        if (in_array('career-service', array_column($product_option->product->tags->toArray(), 'slug'))) {
            $product_type = 'career-service';
            $breadcrumb = array('name' => 'Career Services', 'link' => '/career-services');
        } else if (in_array('webinar', array_column($product_option->product->tags->toArray(), 'slug'))) {
            if (!$user->can('view-clubhouse')) {
                return redirect()->back()->withErrors(['msg' => 'You must be a Clubhouse Pro member to RSVP to webinars.']);
            }
            $product_type = 'webinar';
            $breadcrumb = array('name' => 'Educational Webinars', 'link' => '/webinars');
        } else {
            $product_type = 'membership';
            $breadcrumb = array('name' => 'Membership', 'link' => '/membership-options');
        }

        return view('checkout/index', [
            'product_option' => $product_option,
            'payment_methods' => (!is_null($stripe_user) && !is_null($stripe_user->sources) ? $stripe_user->sources->data : array()),
            'product_type' => $product_type,
            'breadcrumb' => [
                'Clubhouse' => '/',
                $breadcrumb['name'] => $breadcrumb['link'],
                'Checkout' => null,
                "{$product_option->product->name}" => "{$breadcrumb['link']}/{$product_option->product->id}",
                "{$product_option->name}" => ""
            ]
        ]);
    }

    public function store(StoreCheckout $request)
    {
        $user = Auth::user();

        try {
            $checkout_type;
            if (preg_match('/sku/', $request['stripe_product_id'])) {
                $order = StripeServiceProvider::purchaseSku($user, $request['payment_method'], $request['stripe_product_id']);
                $product_option = ProductOption::with('product')->where('stripe_sku_id', $request['stripe_product_id'])->first();
                try {
                    $product_option->quantity = $product_option->quantity - 1;
                    $product_option->save();
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
                try {
                    foreach ($product_option->product->tags as $tag) {
                        if ($tag->slug == 'career-service') {
                            Mail::to($user)->send(new UserPaid($user, $product_option, $order->amount));
                            Mail::to($user)->send(new UserPaidCareerService($user, $product_option));
                            $checkout_type = 'career-service';
                            break;
                        } else if ($tag->slug == 'webinar') {
                            Mail::to($user)->send(new UserPaidWebinar($user, $product_option));
                            $checkout_type = 'webinar';
                            break;
                        }
                    }
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            } else if (preg_match('/plan/', $request['stripe_product_id'])) {
                $plan = StripeServiceProvider::purchasePlan($user, $request['payment_method'], $request['stripe_product_id']);
                $product_option = ProductOption::with('product')->where('stripe_plan_id', $request['stripe_product_id'])->first();
                $roles = Role::where('code', 'clubhouse')->get();
                $user->roles()->attach($roles);
                try {
                    Mail::to($user)->send(new UserPaid($user, $product_option));
                    Mail::to($user)->send(new UserPaidClubhousePro($user));
                    $checkout_type = 'membership';
                } catch (\Exception $e) {
                    Log::error($e->getMessage());
                }
            } else {
                return redirect()->back()->withErrors(['msg' => 'Invalid product.']);
            }
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->back()->withErrors(['msg' => 'We were unable to complete your transaction at this time.']);
        }

        return redirect()->action('CheckoutController@thanks', array('type' => $checkout_type, 'product_option_id' => $product_option->id));
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

    public function removeCard(Request $request)
    {
        $user = Auth::user();

        try {
            $stripe_customer = StripeServiceProvider::getCustomer($user);
            $stripe_customer->sources->retrieve($request['card_id'])->delete();
        } Catch (Exception $e) {
            Log::error($e);
        }

        return response()->json([
            'type' => 'success'
        ]);
    }

    public function makeCardPrimary(Request $request)
    {
        $user = Auth::user();

        try {
            $stripe_customer = StripeServiceProvider::getCustomer($user);
            $stripe_customer->default_source = $request['card_id'];
            $stripe_customer->save();
        } Catch (Exception $e) {
            Log::error($e);
        }

        return response()->json([
            'type' => 'success'
        ]);
    }

    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();

        try {
            $stripe_customer = StripeServiceProvider::getCustomer($user);
            StripeServiceProvider::cancelUserSubscription($request['subscription_id']);
            $subscriptions = StripeServiceProvider::getCustomer($user)->subscriptions;

            // Remove clubhouse role from user
            $role = RoleUser::where(array(array('role_code', 'clubhouse'), array('user_id', $user->id)))->first();
            if ($role) {
                $role->delete();
            }
        } Catch (Exception $e) {
            Log::error($e);
        }

        return response()->json([
            'type' => 'success',
            'subscriptions' => $subscriptions
        ]);
    }

    public function thanks(Request $request)
    {
        $user = Auth::user();

        $product_option = ProductOption::with('product')->find($request['product_option_id']);

        switch ($request['type']) {
            case 'career-service':
                $view = 'career-service-thanks';
                $breadcrumb = 'Career Service';
                $link = '/career-services';
                break;
            case 'webinar':
                $view = 'webinar-thanks';
                $breadcrumb = 'Webinar';
                $link = '/webinars';
                break;
            case 'membership':
                $view = 'membership-thanks';
                $breadcrumb = 'Membership';
                $link = '/membership-options';
                break;
            default:
                $view = 'thanks';
                $breadcrumb = 'Product';
                break;
        }

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
}
