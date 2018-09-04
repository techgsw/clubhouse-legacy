<?php

namespace App\Providers;

use App\Product;
use App\ProductOption;
use Illuminate\Support\ServiceProvider;
use Stripe;


class StripeServiceProvider extends ServiceProvider
{
    public static function createProduct(Product $product)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_product = Stripe\Product::create(
            array(
                'name' => $product->name,
                'description' => $product->description,
                'type' => $product->type,
            )
        );

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

    public static function createSku(Stripe\Product $stripe_product, ProductOption $product_option)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_sku = Stripe\Sku::create(
            array(
                'product' => $stripe_product->id,
                'currency' => 'usd',
                'inventory' => array( 'type' => 'finite', 'quantity' => $product_option->quantity),
                'price' =>  $product_option->price * 100, // Per API docs
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
        $stripe_product->description = $product->description;
        $stripe_product->save();

        return $stripe_product;
    }

    public static function updatePlan(ProductOption $product_option)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_plan = Stripe\Plan::retrieve($product_option->stripe_plan_id);
        $stripe_plan->nickname = $product_option->name;
        $stripe_plan->amount = $product_option->price * 100; // Per API docs
        $stripe_plan->save();

        return $stripe_plan;
    }

    public static function updateSku(ProductOption $product_option)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $stripe_sku = Stripe\Sku::retrieve($product_option->stripe_sku_id);
        $stripe_sku->inventory = array( 'type' => 'finite', 'quantity' => $product_option->quantity);
        $stripe_sku->price = $product_option->price * 100; // Per API docs
        $stripe_sku->save();

        return $stripe_sku;
    }

    public static function deleteProduct(Stripe\Product $product)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $product->delete();
    }

    public static function deletePlan(Stripe\Plan $plan)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $plan->delete();
    }

    public static function deleteSku(Stripe\Sku $sku)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $sku->delete();
    }
}
