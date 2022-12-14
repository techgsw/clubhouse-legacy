<?php

namespace App\Http\Controllers;

use App\Exceptions\SBSException;
use App\Providers\MailchimpServiceProvider;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Mail\CancelNotification;
use App\Mail\UserPaid;
use App\Mail\UserPaidClubhousePro;
use App\Mail\UserPaidCareerService;
use App\Mail\UserPaidWebinar;
use App\Message;
use App\Job;
use App\Role;
use App\Transaction;
use App\TransactionProductOption;
use App\RoleUser;
use App\ProductOption;
use App\Http\Requests\StoreCheckout;
use App\Mail\ClubhouseCancellation;
use App\Providers\EmailServiceProvider;
use App\Providers\StripeServiceProvider;
use App\Providers\ZoomServiceProvider;
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
    public function index(Request $request, $id, $job_id = null)
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
            $is_blocked = false;
            if (Auth::user() && Auth::user()->can('view-clubhouse') && Auth::user()->cannot('view-admin-dashboard')) {
                $is_blocked = Transaction::whereHas('productOptions.product.tags', function ($query) {
                    $query->where('name', 'Career Service');
                })->where('created_at', '>', (new \DateTime())->sub(new \DateInterval('P14D')))
                  ->where('user_id', Auth::user()->id)->count() > 0;
            }
            // TODO adding back in when we add free group career services
            //if ($user->can('view-clubhouse') && !$is_blocked) {
            //    try {

            //        $response = DB::transaction(function () use ($product_option, $user) {
            //            try {
            //                $product_option->quantity = $product_option->quantity - 1;
            //                $product_option->save();
            //            } catch (\Exception $e) {
            //                Log::error($e->getMessage());
            //            }

            //            $transaction = new Transaction();
            //            $transaction->user_id = $user->id;
            //            $transaction->amount = 0;
            //            $transaction->save();

            //            $transaction_product_option = new TransactionProductOption();
            //            $transaction_product_option->transaction_id = $transaction->id;
            //            $transaction_product_option->product_option_id = $product_option->id;
            //            $transaction_product_option->save();

            //            try {
            //                EmailServiceProvider::sendCareerServicePurchaseNotificationEmail($user, $product_option, 0, 'career-service');
            //                Mail::to($user)->send(new UserPaidCareerService($user, $product_option, $transaction->id));
            //            } catch (Exception $e) {
            //                Log::error($e);
            //            }

            //            return array(
            //                'type' => 'career-service',
            //                'product_option_id' => $product_option->id,
            //                'transaction_id' => $transaction->id
            //            );
            //        });

            //        return redirect()->action('CheckoutController@thanks', $response);
            //    } catch (Exception $e) {
            //        Log::error($e);
            //        return redirect()->back()->withErrors(['msg' => 'We were unable to complete your transaction at this time.']);
            //    }
            //} else {
                $product_type = 'career-service';
                $breadcrumb = array('name' => 'Career Services', 'link' => '/career-services');
            //}
        } else if (in_array('webinar', array_column($product_option->product->tags->toArray(), 'slug'))
            || in_array('#samehere', array_column($product_option->product->tags->toArray(), 'slug')))
        {
            if ($product_option->price > 0) {
                $product_type = 'webinar';
                $breadcrumb = array('name' => 'Educational Webinars', 'link' => '/webinars');
            } else {
                $previous_transaction = DB::table('transaction')
                    ->join('transaction_product_option', 'transaction.id', '=', 'transaction_id')
                    ->where('product_option_id', $product_option->id)
                    ->where('user_id', $user->id)->first();

                if ($previous_transaction) {
                    return redirect()->back()->withErrors(['msg' => 'You have already registered for this webinar.']);
                }

                try {
                    $zoom_response = ZoomServiceProvider::addRegistrant($product_option->zoom_webinar_id, $user);

                    $response = DB::transaction(function () use ($product_option, $user) {
                        try {
                            $product_option->quantity = $product_option->quantity - 1;
                            $product_option->save();
                        } catch (\Exception $e) {
                            Log::error($e->getMessage());
                        }

                        $transaction = new Transaction();
                        $transaction->user_id = $user->id;
                        $transaction->amount = 0;
                        $transaction->save();

                        $transaction_product_option = new TransactionProductOption();
                        $transaction_product_option->transaction_id = $transaction->id;
                        $transaction_product_option->product_option_id = $product_option->id;
                        $transaction_product_option->save();

                        return array('type' => 'webinar', 'product_option_id' => $product_option->id);
                    });

                    return redirect()->action('CheckoutController@thanks', $response);
                } catch (Exception $e) {
                    // TODO try to refund order if it went through
                    Log::error($e);
                    return redirect()->back()->withErrors(['msg' => 'We were unable to complete your transaction at this time.']);
                }
            }
        } else if ($product_option->id == PRODUCT_OPTION_ID['premium_job']) {
            $product_type = 'job-premium';
            $breadcrumb = array('name' => 'Job Posting', 'link' => '/job-options');
        } else if ($product_option->id == PRODUCT_OPTION_ID['platinum_job']) {
            $product_type = 'job-platinum';
            $breadcrumb = array('name' => 'Job Posting', 'link' => '/job-options');
        } else if ($product_option->id == PRODUCT_OPTION_ID['premium_job_upgrade']) {
            $product_type = 'job-premium-upgrade';
            $breadcrumb = array('name' => 'Job Posting', 'link' => '/job-options');

            $job = Job::find($job_id);
            if (!$job || $job->user_id != $user->id) {
                return redirect('/user/' . $user->id . '/job-postings')->withErrors(['msg' => 'We are sorry. We are unable to find the job you are looking for.']);
            }
            if (in_array($job->job_type_id, array(JOB_TYPE_ID['user_platinum'], JOB_TYPE_ID['user_premium']))) {
                return redirect('/user/' . $user->id . '/job-postings')->withErrors(['msg' => 'We are sorry. It looks like this job is already upgraded!']);
            }
        } else if ($product_option->id == PRODUCT_OPTION_ID['job_extension']) {
            $product_type = 'job-extension';
            $breadcrumb = array('name' => 'Job Posting', 'link' => '/job-options');

            $job = Job::find($job_id);
            if (!$job || $job->user_id != $user->id) {
                return redirect('/user/' . $user->id . '/job-postings')->withErrors(['msg' => 'We are sorry. We are unable to find the job you are looking for.']);
            }
            $job->extended_at = new \DateTime('now');
            if ($job->job_status_id == JOB_STATUS_ID['expired']) {
                $job->job_status_id = JOB_STATUS_ID['open'];
            }
            $job->save();
            Session::flash('message', new Message(
                "Your job posting has been extended",
                "success",
                $code = null,
                $icon = "check_circle"
            ));
            return redirect('/user/' . $user->id . '/job-postings');
        } else if (in_array($product_option->id, array(PRODUCT_OPTION_ID['platinum_job_upgrade'], PRODUCT_OPTION_ID['platinum_job_upgrade_premium']))) {
            $product_type = 'job-platinum-upgrade';
            $breadcrumb = array('name' => 'Job Posting', 'link' => '/job-options');

            $job = Job::find($job_id);
            if (!$job || $job->user_id != $user->id) {
                return redirect('/user/'.$user->id.'/job-postings')->withErrors(['msg' => 'We are sorry. We are unable to find the job you are looking for.']);
            }
            if ($job->job_type_id == JOB_TYPE_ID['user_platinum']) {
                return redirect('/user/'.$user->id.'/job-postings')->withErrors(['msg' => 'We are sorry. It looks like this job is already Platinum!']);
            }
        } else {
            $product_type = 'membership';
            $breadcrumb = array('name' => 'PRO Membership', 'link' => '/pro-membership');
        }

        return view('checkout/index', [
            'product_option' => $product_option,
            'payment_methods' => (!is_null($stripe_user) && !is_null($stripe_user->sources) ? $stripe_user->sources->data : array()),
            'product_type' => $product_type,
            'job_id' => ((isset($job)) ? $job->id : null),
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
            $response = DB::transaction(function () use ($request, $user) {
                $checkout_type;
                if (preg_match('/sku/', $request['stripe_product_id'])) {
                    $product_option = ProductOption::with('product')->where('stripe_sku_id', $request['stripe_product_id'])->first();

                    if (in_array(
                            $product_option->id,
                            array(
                                PRODUCT_OPTION_ID['premium_job_upgrade'],
                                PRODUCT_OPTION_ID['platinum_job_upgrade'],
                                PRODUCT_OPTION_ID['platinum_job_upgrade_premium'],
                                PRODUCT_OPTION_ID['job_extension']
                            )
                        )
                    ) {
                        $now = new \DateTime('NOW');
                        $job = Job::find($request['job_id']);
                        if (!$job || $job->user_id != $user->id) {
                            return false;
                        }

                        if ($product_option->id == PRODUCT_OPTION_ID['job_extension']) {
                            $job->extended_at = $now;
                            if ($job->job_status_id == JOB_STATUS_ID['expired']) {
                                $job->job_status_id = JOB_STATUS_ID['open'];
                            }
                        } else {
                            if ($product_option->id == PRODUCT_OPTION_ID['premium_job_upgrade']) {
                                $job->job_type_id = JOB_TYPE_ID['user_premium'];
                            } elseif (in_array($product_option->id, array(PRODUCT_OPTION_ID['platinum_job_upgrade'], PRODUCT_OPTION_ID['platinum_job_upgrade_premium']))) {
                                $job->job_type_id = JOB_TYPE_ID['user_platinum'];
                            } else {
                                return false;
                            }
                            $job->upgraded_at = $now;
                            $job->featured = 1;
                        }

                        $job->save();
                    }

                    $order = StripeServiceProvider::purchaseSku($user, $request['payment_method'], $request['stripe_product_id']);

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
                    if (isset($job) && !is_null($job)) {
                        $transaction->job_id = $job->id;
                    }
                    $transaction->save();

                    $transaction_product_option = new TransactionProductOption();
                    $transaction_product_option->transaction_id = $transaction->id;
                    $transaction_product_option->product_option_id = $product_option->id;
                    $transaction_product_option->save();

                    if (in_array(
                            $product_option->id,
                            array(
                                PRODUCT_OPTION_ID['premium_job'],
                                PRODUCT_OPTION_ID['platinum_job'],
                                PRODUCT_OPTION_ID['premium_job_upgrade'],
                                PRODUCT_OPTION_ID['platinum_job_upgrade'],
                                PRODUCT_OPTION_ID['platinum_job_upgrade_premium'],
                                PRODUCT_OPTION_ID['job_extension'],
                            )
                        )
                    ) {
                        try {
                            Mail::to($user)->send(new UserPaid($user, $product_option, $order->amount));
                        } catch (\Exception $e) {
                            Log::error($e->getMessage());
                        }
                        if ($product_option->id == PRODUCT_OPTION_ID['premium_job']) {
                            $checkout_type = 'job-premium';
                            try {
                                EmailServiceProvider::sendJobPremiumPurchaseNotificationEmail($user, $product_option, $order->amount, 'premium-job');
                            } catch (\Exception $e) {
                                Log::error($e->getMessage());
                            }
                        } elseif ($product_option->id == PRODUCT_OPTION_ID['premium_job_upgrade']) {
                            $checkout_type = 'job-premium-upgrade';
                            try {
                                EmailServiceProvider::sendJobPremiumPurchaseNotificationEmail($user, $product_option, $order->amount, 'premium-job-upgrade');
                            } catch (\Exception $e) {
                                Log::error($e->getMessage());
                            }
                        } elseif ($product_option->id == PRODUCT_OPTION_ID['platinum_job']) {
                            $checkout_type = 'job-platinum';
                            try {
                                EmailServiceProvider::sendJobPlatinumPurchaseNotificationEmail($user, $product_option, $order->amount, 'platinum-job');
                            } catch (\Exception $e) {
                                Log::error($e->getMessage());
                            }
                        } elseif (in_array($product_option->id, array(PRODUCT_OPTION_ID['platinum_job_upgrade'], PRODUCT_OPTION_ID['platinum_job_upgrade_premium']))) {
                            $checkout_type = 'job-platinum-upgrade';
                            try {
                                EmailServiceProvider::sendJobPlatinumPurchaseNotificationEmail($user, $product_option, $order->amount, 'platinum-job-upgrade');
                            } catch (\Exception $e) {
                                Log::error($e->getMessage());
                            }
                        } elseif ($product_option->id == PRODUCT_ID['job_extension']) {
                            $checkout_type = 'job-extension';
                            try {
                                EmailServiceProvider::sendJobExtensionPurchaseNotificationEmail($user, $product_option, $order->amount, 'job-extension');
                            } catch (\Exception $e) {
                                Log::error($e->getMessage());
                            }
                        }
                    } else {
                        foreach ($product_option->product->tags as $tag) {
                            if ($tag->slug == 'career-service') {
                                try {
                                    EmailServiceProvider::sendCareerServicePurchaseNotificationEmail($user, $product_option, $order->amount, 'career-service');
                                    Mail::to($user)->send(new UserPaid($user, $product_option, $order->amount));
                                    Mail::to($user)->send(new UserPaidCareerService($user, $product_option, $transaction->id));
                                } catch (\Exception $e) {
                                    Log::error($e);
                                }
                                $checkout_type = 'career-service';
                                break;
                            } else if ($tag->slug == 'webinar' || $tag->slug == '#samehere') {
                                try {
                                    EmailServiceProvider::sendWebinarPurchaseNotificationEmail($user, $product_option, 0, 'webinar');
                                    Mail::to($user)->send(new UserPaidWebinar($user, $product_option));
                                } catch (\Exception $e) {
                                    Log::error($e->getMessage());
                                }
                                $checkout_type = 'webinar';
                                break;
                            }
                        }
                    }
                } else if (preg_match('/plan/', $request['stripe_product_id'])) {
                    $product_option = ProductOption::with('product')->where('stripe_plan_id', $request['stripe_product_id'])->first();
                    $roles = Role::where('code', 'clubhouse')->get();
                    $user->roles()->attach($roles);
                    $checkout_type = 'membership';

                    $transaction = new Transaction();
                    $transaction->user_id = $user->id;
                    $transaction->amount = $product_option->price;
                    $transaction->subscription_active_flag=true;
                    $transaction->save();

                    $transaction_product_option = new TransactionProductOption();
                    $transaction_product_option->transaction_id = $transaction->id;
                    $transaction_product_option->product_option_id = $product_option->id;
                    $transaction_product_option->save();

                    $plan = StripeServiceProvider::purchasePlan($user, $request['payment_method'], $request['stripe_product_id']);

                    $transaction->stripe_subscription_id = $plan->id;
                    $transaction->save();

                    try {
                        EmailServiceProvider::sendMembershipPurchaseNotificationEmail($user, $product_option, 0, 'membership');
                        Mail::to($user)->send(new UserPaid($user, $product_option, $plan->plan->amount, 'membership'));
                        Mail::to($user)->send(new UserPaidClubhousePro($user));
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                    }

                    try {
                        MailchimpServiceProvider::addUserToProMembersList($user);
                    } catch (\Exception $e) {
                        Log::error($e->getMessage());
                    }

                } else {
                    return false;
                }

                return array(
                    'type' => $checkout_type,
                    'product_option_id' => $product_option->id,
                    'transaction_id' => $transaction->id
                );
            });

            if ($response == false) {
                return redirect()->back()->withErrors(['msg' => 'Invalid product.']);
            }
        } catch (\Exception $e) {
            // TODO try to refund order if it went through
            Log::error($e);
            return redirect()->back()->withErrors(['msg' => 'We were unable to complete your transaction at this time.']);
        }

        if (isset($response['type']) && $response['type'] == 'membership' && Session::get('url.intended')) {
            // if a user purchased a clubhouse membership, bring them back to the page they were at before registering/purchasing
            Session::flash('message', new Message(
                "Thank you for becoming a Clubhouse PRO member!",
                "success",
                $code = null,
                $icon = "check_circle"
            ));
            return redirect(Session::get('url.intended'));
        } else {
            return redirect()->action('CheckoutController@thanks', $response);
        }
    }

    public function addCard(Request $request)
    {
        $user = Auth::user();

        try {
            $stripe_customer = null;
            if (!$user->stripe_customer_id) {
                    $stripe_customer = StripeServiceProvider::createCustomer($user);
                    $user->stripe_customer_id = $stripe_customer->id;
                    $user->update();
            } else {
                $stripe_customer = StripeServiceProvider::getCustomer($user);
            }

            if ($request['make_primary']) {
                // stripe allows failed invoices to be repaid if the "soruce" attribute is set in an update
                // note that this will delete the existing default payment instead of just making it not the default
                $stripe_customer->source = $request['stripe_token'];
                $stripe_customer->save();
                // if the user has failed invoice payments, we want to give stripe a couple of seconds to retry
                // before we redirect back to the account page
                sleep(7);
            } else {
                $stripe_customer->sources->create(array('source' => $request['stripe_token']));
            }
            $stripe_customer = StripeServiceProvider::getCustomer($user);

            return response()->json([
                'type' => 'success',
                'payment_methods' => $stripe_customer->sources->data
            ]);
        } Catch (\Exception $e) {
            Log::error($e);

            //TODO: Send error message in the JS to handle this exception
            return response()->json([
                'type' => 'failure',
                'payment_methods' => null
            ]);
        }

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
            $request->session()->flash('message', new Message(
                "There was an error making your card the primary card. Please contact ' . __('email.info_address') . ' for assistance",
                "danger",
                $code = null,
                $icon = "error"
            ));
        }
        return response()->json([
            'type' => 'success'
        ]);
    }

    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();

        try {
            StripeServiceProvider::cancelUserSubscription($user, $request['subscription_id']);

            try {
                Mail::to(env('CLUBHOUSE_EMAIL'))->send(new CancelNotification($user));
                Mail::to($user)->send(new ClubhouseCancellation($user));
            } catch (Exception $e) {
                Log::error($e);
            }
        } Catch (\Stripe\Error\Base $e) {
            Log::error($e);
            return response()->json([
                'type' => 'failure',
            ]);
        } Catch (SBSException $e) {
            Log::error($e);
            return response()->json([
                'type' => 'failure',
            ]);
        } Catch (Exception $e) {
            // not a stripe error, cancel was successful. user doesn't need to know about these errors.
            Log::error($e);
        }

        return response()->json([
            'type' => 'success',
        ]);
    }

    public function reactivateSubscription(Request $request)
    {
        $user = Auth::user();

        try {
            StripeServiceProvider::reactivateUserSubscription($user, $request['subscription_id']);
        } Catch (\Stripe\Error\Base $e) {
            Log::error($e);
            return response()->json([
                'type' => 'failure',
            ]);
        } Catch (SBSException $e) {
            Log::error($e);
            return response()->json([
                'type' => 'failure',
            ]);
        } Catch (Exception $e) {
            // not a stripe error, reactivate was successful. user doesn't need to know about these errors.
            Log::error($e);
        }

        return response()->json([
            'type' => 'success',
        ]);
    }

    public function thanks(Request $request)
    {
        $user = Auth::user();

        $product_option = ProductOption::with('product')->find($request['product_option_id']);

        $transaction = null;

        $breadcrumb = array(
            'Clubhouse' => '/',
            'Checkout' => '',
        );

        switch ($request['type']) {
            case 'career-service':
                $view = 'career-service-thanks';
                $breadcrumb['Career Service'] = '/career-services';
                $transaction = Transaction::find($request['transaction_id']);
                break;
            case 'webinar':
                $view = 'webinar-thanks';
                $breadcrumb = array(
                    'Clubhouse' => '/',
                    'Webinars' => '/webinars',
                    'RSVP' => '',
                );
                break;
            case 'job-premium':
                $view = 'job-premium-thanks';
                $breadcrumb['Job Posting Premium'] = '/job-options';
                break;
            case 'job-platinum':
                $view = 'job-platinum-thanks';
                $breadcrumb['Job Posting Platinum'] = '/job-options';
                break;
            case 'job-premium-upgrade':
                $view = 'job-premium-upgrade-thanks';
                $breadcrumb['Job Posting Premium Upgrade'] = '/job-options';
                break;
            case 'job-platinum-upgrade':
                $view = 'job-platinum-upgrade-thanks';
                $breadcrumb['Job Posting Platinum Upgrade'] = '/job-options';
                break;
            case 'job-extension':
                $view = 'job-extension-thanks';
                $breadcrumb['Job Extension'] = '/job-options';
                break;
            case 'membership':
                $view = 'membership-thanks';
                $breadcrumb['PRO Membership'] = '/pro-membership';
                break;
            default:
                $view = 'thanks';
                $breadcrumb['Product'] = '';
                break;
        }

        $breadcrumb['Thanks'] = '';

        return view('checkout/'.$view, [
            'breadcrumb' => $breadcrumb,
            'product_option' => $product_option,
            'transaction' => $transaction
        ]);
    }
}
