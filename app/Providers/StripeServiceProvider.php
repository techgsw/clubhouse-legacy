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

        $product_array = array(
            'name' => $product->name,
            'type' => $product->type,
        );

        if ($product->type == 'good') {
            $product_array['description'] = $product->description;
            $product_array['attributes'] = array('product_option_id', 'name', 'description');
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
}
