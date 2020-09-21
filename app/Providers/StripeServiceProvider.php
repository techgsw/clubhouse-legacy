<?php

namespace App\Providers;

use App\Exceptions\SBSException;
use App\Product;
use App\ProductOption;
use App\Transaction;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use Stripe;


class StripeServiceProvider extends ServiceProvider
{
    public static function getCustomer(User $user)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        if (is_null($user->stripe_customer_id)) {
            return null;
        } else {
            try {
                $stripe_customer = Stripe\Customer::retrieve($user->stripe_customer_id);
            } catch (\Exception $e) {
                return null;
            }
        }

        return $stripe_customer;
    }

    public static function getUserTransactions(User $user)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $transactions = array('subscriptions' => array(), 'orders' => array());

        if (is_null($user->stripe_customer_id)) {
            return $transactions;
        }

        $stripe_transactions = Stripe\Invoice::all(
            array(
                "customer" => $user->stripe_customer_id
            )
        );

        $stripe_orders = Stripe\Order::all(
            array(
                "customer" => $user->stripe_customer_id
            )
        );
        
        foreach ($stripe_transactions->data as $key => $invoice) {
            if (!is_null($invoice->charge)) {
                $stripe_charge = Stripe\Charge::retrieve($invoice->charge);
                $transactions['subscriptions'][] = array(
                    'invoice' => $invoice,
                    'charge_object' => $stripe_charge
                );
            } else {
                $transactions['subscriptions'][] = array(
                    'invoice' => $invoice
                );
            }
        }

        foreach ($stripe_orders->data as $key => $order_item) {
            $items = array();
            $total_amount = 0;
            foreach ($order_item->items as $key => $item) {
                if (!in_array($item->type, array('shipping', 'tax'))) {
                    if ($item->type != 'discount') {
                        $items[] = $item;
                    }
                    $total_amount += $item->amount;
                }
            }
            $transaction = array(
                'order' => array(
                    'id' => $order_item->id,
                    'total_amount' => $total_amount,
                    'created' => $order_item->created,
                    'items' => $items
                )
            );
            if (!is_null($order_item->charge)) {
                $stripe_charge = Stripe\Charge::retrieve($order_item->charge);
                $transaction['order']['charge_object'] = $stripe_charge;
            }
            $transactions['orders'][] = $transaction;
        }

        return $transactions;
    }

    public static function createCustomer(User $user)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_customer = Stripe\Customer::create(
            array(
                'email' => $user->email,
                'description' => $user->first_name.' '.$user->last_name,
            )
        );

        return $stripe_customer;
    }

    public static function createProduct(Product $product)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $product_array = array(
            'name' => $product->name,
            'type' => $product->type,
        );

        if ($product->type == 'good') {
            $product_array['description'] = $product->description;
            $product_array['attributes'] = array('product_option_id', 'name', 'description');
            $product_array['shippable'] = false;
        }

        $stripe_product = Stripe\Product::create($product_array);

        return $stripe_product;
    }

    public static function createPlan(Stripe\Product $stripe_product, ProductOption $product_option)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_plan = Stripe\Plan::create(
            array(
                'product' => $stripe_product->id,
                'nickname' => $product_option->name,
                'interval' => 'month',
                'currency' => 'usd',
                'amount' =>  $product_option->price * 100 // Per API docs
            )
        );

        return $stripe_plan;
    }

    public static function createSKU(Stripe\Product $stripe_product, ProductOption $product_option)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_sku = Stripe\SKU::create(
            array(
                'product' => $stripe_product->id,
                'currency' => 'usd',
                'inventory' => array( 'type' => 'finite', 'quantity' => $product_option->quantity),
                'price' =>  $product_option->price * 100, // Per API docs
                'attributes' => array('product_option_id' => $product_option->id, 'name' => $product_option->name, 'description' => $product_option->description),
                'metadata' => array('product_option_id' => $product_option->id)
            )
        );

        return $stripe_sku;
    }

    public static function updateProduct(Product $product)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_product = Stripe\Product::retrieve($product->stripe_product_id);

        $stripe_product->name = $product->name;
        if ($product->type == 'good') {
            $stripe_product->description = $product->description;
            $stripe_product->attributes = array('product_option_id', 'name', 'description');
        }
        $stripe_product->save();

        return $stripe_product;
    }

    public static function updatePlan(Stripe\Product $product, ProductOption $product_option)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        if (!$product_option->stripe_plan_id) {
            return StripeServiceProvider::createPlan($product, $product_option);
        }

        $stripe_plan = Stripe\Plan::retrieve($product_option->stripe_plan_id);
        $stripe_plan->nickname = $product_option->name;
        $stripe_plan->save();

        return $stripe_plan;
    }

    public static function updateSKU(Stripe\Product $product, ProductOption $product_option)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        if (!$product_option->stripe_sku_id) {
            return StripeServiceProvider::createSKU($product, $product_option);
        }

        $stripe_sku = Stripe\SKU::retrieve($product_option->stripe_sku_id);

        $stripe_sku->inventory = array( 'type' => 'finite', 'quantity' => $product_option->quantity);
        $stripe_sku->price = $product_option->price * 100; // Per API docs
        $stripe_sku->attributes = array('product_option_id' => $product_option->id, 'name' => $product_option->name, 'description' => $product_option->description);
        $stripe_sku->save();

        return $stripe_sku;
    }

    public static function deleteProduct(Stripe\Product $product)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $product->delete();
    }

    public static function deletePlan(ProductOption $product_option)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_plan = Stripe\Plan::retrieve($product_option->stripe_plan_id);

        $stripe_plan->delete();
    }

    public static function deleteSKU(ProductOption $product_option)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_sku = Stripe\SKU::retrieve($product_option->stripe_sku_id);

        $stripe_sku->delete();
    }

    public static function purchasePlan(User $user, string $source_token, string $plan_id)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_customer = Stripe\Customer::retrieve($user->stripe_customer_id);

        $stripe_subscription = Stripe\Subscription::create(
            array(
                'customer' => $stripe_customer->id,
                'items' => array(
                    array(
                        'plan' => $plan_id,
                    )
                ),
                'trial_period_days' => CLUBHOUSE_FREE_TRIAL_DAYS
            )
        );

        return $stripe_subscription;
    }

    public static function cancelUserSubscription(User $user, string $subscription_id)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $subscription = Stripe\Subscription::retrieve($subscription_id);

        if (!is_null($subscription) && !is_null($subscription->customer) && !is_null($user->stripe_customer_id)
            && $subscription->customer == $user->stripe_customer_id
        ) {
            $subscription->cancel();
        } else {
            throw new SBSException('Subscription customer ID '.$subscription->customer.' for '.$subscription_id
                .' does not match user stripe ID '.$user->stripe_customer_id.' , or there are null values.');
        }
        try {
            Transaction::where('stripe_subscription_id', $subscription_id)->update(['subscription_active_flag' => 0]);
        } catch (\Throwable $t) {
            // not critical, the cron job in the morning should correctly update this
            Log::warn($t);
        }

    }

    public static function purchaseSku(User $user, string $source_token, string $sku_id)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_customer = Stripe\Customer::retrieve($user->stripe_customer_id);

        $items = array(
            array(
                'type' => 'sku',
                'parent' => $sku_id
            )
        );

        if (!is_null($stripe_customer)) {
            if (!$stripe_customer->delinquent && $stripe_customer->subscriptions->total_count > 0) {
                $sku = Stripe\Sku::retrieve($sku_id);
                if ($sku->price > 0) {
                    $items[] = array(
                        'type' => 'discount',
                        'currency' => 'usd',
                        'description' => 'Clubhouse Pro discount',
                        'amount' => (int)(round($sku->price / 2) * -1)
                    );
                }
            }
        }

        $stripe_order = Stripe\Order::create(
            array(
                'currency' => 'usd',
                'items' => $items,
                'customer' => $stripe_customer->id
            )
        );

        try {
            $stripe_order = $stripe_order->pay(array('customer' => $stripe_customer->id, 'source' => $source_token));
        } catch (\Exception $e) {
            Log::error($e);
            $stripe_order->status = 'canceled';
            $stripe_order->save();
            throw Exception('Unable to process transaction at this time.');
        }

        return $stripe_order;
    }

    /**
     * Pull a list of failed card transactions since a certain date
     *
     * @param $start_date unix timestamp beginning of date range
     * @return object with an array of failed transactions.
     * Notable fields:
     * $result->data = array of failed transactions
     * $result->data[$i]->data->object->attempt_count = number of times the transaction has been attempted
     * $result->data[$i]->data->object->customer = stripe ID of customer
     * $result->data[$i]->data->object->customer_email = email of customer
     * $result->data[$i]->data->object->lines->data[$i]->plan->product = product ID attempted to purchase (note: may be multiple)
     */
    public static function getFailedTransactionsSince($start_date) 
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
        return Stripe\Event::all([
            "created[gt]" => $start_date->getTimestamp(),
            "type" => 'invoice.payment_failed'
        ]);
    }

    /**
     * Pulls all subscriptions from stripe and updates their subscription_active_flag in the transaction table
     */ 
    public static function syncAllTransactionSubscriptions() 
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
        $subscriptions = array();
        $last_subscription_id = null;
        do {
            $subscriptions = Stripe\Subscription::all([
                "status" => 'active',
                "limit" => 100,
                "starting_after" => $last_subscription_id
            ]);
            
            usleep(100000);

            foreach ($subscriptions->data as $subscription) {
                if (!is_null($transaction = Transaction::where('stripe_subscription_id', $subscription->id)->first())) {
                    $transaction->subscription_active_flag = in_array($subscription->status, ['cancelled', 'unpaid', 'incomplete-expired']) ? 0 : 1;
                    $transaction->save();
                }
            }
            Log::info("100 subscriptions updated");
            $last_subscription_id = end($subscriptions->data)->id;
        } while($subscriptions->has_more);

        // update all transactions we couldn't find in stripe (cancelled subscriptions)
        Transaction::whereNotNull('stripe_subscription_id')
            ->whereNull('subscription_active_flag')
            ->update(['subscription_active_flag' => 0]);
    }

    public static function updateSubscriptionStatusesSince($start_date)
    {
        Log::info('Starting stripe subscription sync (for clubhouse users) :');
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));
        $subscription_events = Stripe\Event::all([
            "created[gt]" => $start_date->getTimestamp(),
            "types" => [
                'customer.subscription.deleted',
                'customer.subscription.updated'
            ]
        ]);

        // Stripe returns events in descending date order. We want to update transactions in the order the events happened.
        foreach (array_reverse($subscription_events->data) as $subscription_event) {
            if ($subscription_event->type == 'customer.subscription.deleted' || in_array($subscription_event->data->object->status, ['unpaid', 'incomplete-expired', 'cancelled'])) {
                Transaction::where('stripe_subscription_id', $subscription_event->data->object->id)
                    ->update(['subscription_active_flag' => 0]);
                Log::info('Subscription '.$subscription_event->data->object->id.' deactivated');
                if (in_array($subscription_event->data->object->status, ['unpaid', 'incomplete-expired'])) {
                    $delinquent_user = User::where('stripe_customer_id', $subscription_event->data->object->customer)->first();
                    $role = RoleUser::where(array(array('role_code', 'clubhouse'), array('user_id', $delinquent_user->id)))->first();
                    if ($role) {
                        $role->delete();
                    }
                    Log::info('Clubhouse role for user '.$delinquent_user->id.' deleted');
                }
            } else if ($subscription_event->type == 'customer.subscription.updated' && $subscription_event->data->object->status == 'active') {
                Log::info('Subscription '.$subscription_event->data->object->id.' activated');
                Transaction::where('stripe_subscription_id', $subscription_event->data->object->id)
                    ->update(['subscription_active_flag' => 1]);
            }
        }
    }
}
