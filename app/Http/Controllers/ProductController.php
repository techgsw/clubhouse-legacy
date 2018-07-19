<?php

namespace App\Http\Controllers;

use \Exception;
use App\Product;
use App\ProductOption;
// TODO use App\Http\Requests\StoreProduct;
// TODO use App\Http\Requests\UpdateProduct;
use App\Providers\ImageServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        return view('product/index', [
            'breadcrumb' => [
                'Home' => '/',
                'Product' => '/product'
            ]
        ]);
    }

    public function admin()
    {
        $this->authorize('admin-product');

        return view('product/admin', [
            'breadcrumb' => [
                'Home' => '/',
                'Product' => '/admin/product'
            ]
        ]);
    }

    public function create()
    {
        $this->authorize('create-product');

        return view('product/create', [
            'breadcrumb' => [
                'Home' => '/',
                'Product' => '/admin/product',
                'New Product' => '/product/create'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create-product');

        $product = DB::transaction(function ($request) {
            $product = new Product;
            $product->name = request('name');
            $product->description = request('description');
            $product->active = request('active');
            $product->save();

            foreach (request('option') as $i => $params) {
                $option = new ProductOption;
                $option->name = $params['name'];
                $option->price = $params['price'];
                $option->description = $params['description'];
                $option->product_id = $product->id;
                $option->save();
            }
        });

        return redirect()->action('ProductController@show', [$product]);
    }

    public function edit($id)
    {
        $this->authorize('edit-product');

        $product = Product::where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        return view('product/edit', [
            'product' => $product,
            'breadcrumb' => [
                'Home' => '/',
                'Product' => '/admin/product',
                "{$product->name}" => "/product/{$product->id}",
                "Edit" => "/product/{$product->id}/edit"
            ]
        ]);
    }

    public function update(UpdateProduct $request, $id)
    {
        $this->authorize('edit-product');

        $product = Product::where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        $product = DB::transaction(function () {
            // TODO
        });

        return redirect()->action('ProductController@edit', [$product]);
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        return view('product/show', [
            'product' => $product,
            'breadcrumb' => [
                'Home' => '/',
                'Product' => Auth::user() && Auth::user()->can('view-admin-product') ? '/admin/product' : '/product',
                "{$product->name}" => "/product/{$product->id}"
            ]
        ]);
    }
}
