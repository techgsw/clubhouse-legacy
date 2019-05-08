<?php

namespace App\Http\Controllers;

use \Exception;
use App\Message;
use App\Product;
use App\ProductOption;
use App\ProductOptionRole;
use App\Tag;
use App\Providers\ImageServiceProvider;
use App\Providers\StripeServiceProvider;
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
                'Clubhouse' => '/',
                'Product' => '/product'
            ]
        ]);
    }

    public function admin(Request $request)
    {
        $this->authorize('admin-product');

        $products = Product::with('options')
            ->filter($request->all())
            ->paginate(15);

        $tags = Tag::has('products')->get();

        return view('product/admin', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Product' => '/product/admin'
            ],
            'products' => $products,
            'tags' => $tags,
        ]);
    }

    public function create()
    {
        $this->authorize('create-product');

        return view('product/create', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Product' => '/product/admin',
                'New Product' => '/product/create'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create-product');

        try {
            $product = DB::transaction(function () use ($request) {
                $product = new Product;
                $product->name = request('name');
                $product->description = request('description');
                $product->active = request('active') ? true : false;
                $product->type = request('type') ? 'service' : 'good';
                $product->save();

                foreach (request('option') as $i => $params) {
                    $option = new ProductOption;
                    $option->name = $params['name'];
                    $option->price = $params['price'];
                    $option->quantity = $params['quantity'];
                    $option->description = $params['description'];
                    $option->product_id = $product->id;
                    $option->save();

                    $roles = [];
                    if (array_key_exists('clubhouse', $params)) {
                        $roles[] = 'clubhouse';
                    }
                    if (array_key_exists('user', $params)) {
                        $roles[] = 'user';
                    }
                    $option->roles()->sync($roles);
                }

                $image_file = request()->file('image_url');
                if ($image_file) {
                    $image = ImageServiceProvider::saveFileAsImage(
                        $image_file,
                        $filename = preg_replace('/\s/', '-', str_replace("/", "", $product->name)).'-SportsBusinessSolutions',
                        $directory = 'product/'.$product->id
                    );
                    $product->images()->attach($image->id);
                }

                $tag_json = request('product_tags_json');
                $tag_names = json_decode($tag_json);
                $product->tags()->sync($tag_names);

                if ($option->price > 0) {

                    try {
                        $stripe_product = StripeServiceProvider::createProduct($product);
                        $product->stripe_product_id = $stripe_product->id;
                        $product->save();
                    } catch (Exception $e) {
                        Log::error($e);
                        if (!is_null($stripe_product)) {
                            StripeServiceProvider::deleteProduct($stripe_product);
                        }
                        throw new Exception('Unable to update product with stripe id.');
                    }

                    foreach ($product->options as $key => $option) {
                        if ($product->type == 'service') {
                            try {
                                $stripe_plan = StripeServiceProvider::createPlan($stripe_product, $option);
                                $option->stripe_plan_id = $stripe_plan->id;
                                $option->save();
                            } catch (Exception $e) {
                                Log::error($e);
                                if (!is_null($stripe_product)) {
                                    StripeServiceProvider::deleteProduct($stripe_product);
                                }
                                if (!is_null($stripe_plan)) {
                                    StripeServiceProvider::deletePlan($stripe_plan);
                                }
                                throw new Exception('Unable to update product option with stripe plan id.');
                            }
                        } else {
                            try {
                                $stripe_sku = StripeServiceProvider::createSku($stripe_product, $option);
                                $option->stripe_sku_id = $stripe_sku->id;
                                $option->save();
                            } catch (Exception $e) {
                                Log::error($e);
                                if (!is_null($stripe_product)) {
                                    StripeServiceProvider::deleteProduct($stripe_product);
                                }
                                if (!is_null($stripe_sku)) {
                                    StripeServiceProvider::deleteSku($stripe_sku);
                                }
                                throw new Exception('Unable to update product option with stripe sku id.');
                            }
                        }
                    }
                }

                return $product;
            });
        } catch (Exception $e) {
            Log::error($e);

            $request->session()->flash('message', new Message(
                "Failed to save product. Please try again.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return redirect()->back()->withInput();
        }

        $request->session()->flash('message', new Message(
            "Product saved",
            "success",
            $code = null,
            $icon = "check_circle"
        ));

        return redirect()->action('ProductController@show', [$product]);
    }

    public function edit($id)
    {
        $this->authorize('edit-product');

        $product = Product::where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        $tags = [];
        foreach ($product->tags as $tag) {
            $tags[] = $tag->name;
        }
        $product_tags_json = json_encode($tags);

        return view('product/edit', [
            'product' => $product,
            'product_tags_json' => $product_tags_json,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Product' => '/product/admin',
                "{$product->name}" => "/product/{$product->id}",
                "Edit" => "/product/{$product->id}/edit"
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit-product');

        $product = Product::where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        try {
            $product = DB::transaction(function () use ($product, $request) {
                $product->name = request('name');
                $product->description = request('description');
                $product->active = request('active') ? true : false;
                $product->save();

                $options = [];
                $updated_options = [];
                foreach ($product->options as $opt) {
                    $options[$opt->id] = $opt;
                }

                if (count(request('option')) > 0) {
                    foreach (request('option') as $i => $params) {
                        if ($params['id']) {
                            $option = $options[$params['id']] ?: new ProductOption;
                        } else {
                            $option = new ProductOption;
                        }
                        $option->name = $params['name'];
                        if ($product->type == 'good' || $option->id < 1) {
                            $option->price = $params['price'];
                            $option->quantity = $params['quantity'];
                        }
                        $option->description = $params['description'];
                        $option->product_id = $product->id;
                        $option->save();

                        $roles = [];
                        if (array_key_exists('clubhouse', $params)) {
                            $roles[] = 'clubhouse';
                        }
                        if (array_key_exists('user', $params)) {
                            $roles[] = 'user';
                        }
                        $option->roles()->sync($roles);

                        // Remove option from options array so that it doesn't get deleted
                        $updated_options[$option->id] = $option;
                        unset($options[$params['id']]);
                    }
                }

                // Delete options that are not posted
                foreach ($options as $id => $opt) {
                    ProductOptionRole::where('product_option_id', $id)->delete();
                    $opt->delete();

                    if ($product->type == 'service') {
                        StripeServiceProvider::deletePlan($opt);
                    } else {
                        StripeServiceProvider::deleteSku($opt);
                    }
                }

                $image_file = request()->file('image_url');
                if ($image_file) {
                    $image = ImageServiceProvider::saveFileAsImage(
                        $image_file,
                        $filename = preg_replace('/\s/', '-', str_replace("/", "", $product->name)).'-SportsBusinessSolutions',
                        $directory = 'product/'.$product->id
                    );
                    $product->images()->detach();
                    $product->images()->attach($image->id);
                }

                $tag_json = request('product_tags_json');
                $tag_names = json_decode($tag_json);
                $product->tags()->sync($tag_names);

                $stripe_product = StripeServiceProvider::updateProduct($product);

                foreach ($updated_options as $key => $option) {
                    if ($product->type == 'service') {
                        $stripe_plan = StripeServiceProvider::updatePlan($stripe_product, $option);
                        $option->stripe_plan_id = $stripe_plan->id;
                    } else {
                        $stripe_sku = StripeServiceProvider::updateSku($stripe_product, $option);
                        $option->stripe_sku_id = $stripe_sku->id;
                    }
                    $option->save();
                }

                return $product;
            });
        } catch (Exception $e) {
            Log::error($e);
            dd($e->getMessage());
            $request->session()->flash('message', new Message(
                "Failed to save product. Please try again.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return redirect()->back()->withInput();
        }

        $request->session()->flash('message', new Message(
            "Product updated",
            "success",
            $code = null,
            $icon = "check_circle"
        ));

        return redirect()->action('ProductController@edit', [$product]);
    }

    public function show($id)
    {
        $this->authorize('view-product');

        $product = Product::with('options.roles')->where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        $transactions = DB::table('transaction_product_option as tpo')
            ->selectRaw('u.email as email, u.first_name as first_name, u.last_name as last_name, t.amount as price, t.created_at as order_date')
            ->join('transaction as t','tpo.transaction_id', 't.id')
            ->join('product_option as po','tpo.product_option_id', 'po.id')
            ->join('product as p','po.product_id', 'p.id')
            ->join('user as u','t.user_id', 'u.id')
            ->where('p.id',$id)
            ->orderBy('t.id', 'desc')
            ->get();

        return view('product/show', [
            'product' => $product,
            'transactions' => $transactions,
            'breadcrumb' => [
                'Clubhouse' => '/',
                "{$product->name}" => "/product/{$product->id}"
            ]
        ]);
    }

    public function careerServices()
    {
        $products = Product::with('tags')->where('active', 1)->whereHas('tags', function ($query) {
            $query->where('name', 'Career Service');
        })->get();

        $categories = [
            'Career Coaching' => [],
            'Sales Training' => [],
            'Leadership Development' => [],
            'Other' => []
        ];

        foreach ($products as $product) {
            foreach ($categories as $cat => $list) {
                foreach ($product->tags as $tag) {
                    if ($tag->name == $cat) {
                        $categories[$cat][] = $product;
                    }
                }
            }
        }

        return view('product/career-services', [
            'categories' => $categories,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Career Services' => '/career-services'
            ]
        ]);
    }

    public function showCareerServices($id)
    {
        $product = Product::with('options.roles')->where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        // TODO make this resource-driven
        $role = 'user';
        if (Auth::user()) {
            foreach (Auth::user()->roles as $r) {
                if ($r->code == 'clubhouse') {
                    $role = 'clubhouse';
                }
            }
        }

        foreach ($product->options as $i => $option) {
            $option_role_codes = [];
            foreach ($option->roles as $r) {
                $option_role_codes[] = $r->code;
            }
            if (count(array_intersect($option_role_codes, [$role])) == 0) {
                $product->options->forget($i);
            }
        }

        return view('product/career-services/show', [
            'product' => $product,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Career Services' => '/career-services',
                "{$product->name}" => "/career-services/{$product->id}"
            ]
        ]);
    }

    public function webinars()
    {
        $active_products = Product::where('active', true)->with('tags')->whereHas('tags', function ($query) {
            $query->where('name', 'Webinar');
        })->get();

        $inactive_products = Product::where('active', false)->with('tags')->whereHas('tags', function ($query) {
            $query->where('name', 'Webinar');
        })->orderBy('id', 'desc')->get();

        return view('product/webinars', [
            'active_products' => $active_products,
            'inactive_products' => $inactive_products,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Educational Webinars' => '/webinars'
            ]
        ]);
    }

    public function showWebinars($id)
    {
        $product = Product::with('options.roles')->where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        // TODO make this resource-driven
        $role = 'user';
        if (Auth::user()) {
            foreach (Auth::user()->roles as $r) {
                if ($r->code == 'clubhouse') {
                    $role = 'clubhouse';
                }
            }
        }

        foreach ($product->options as $i => $option) {
            $option_role_codes = [];
            foreach ($option->roles as $r) {
                $option_role_codes[] = $r->code;
            }
            if (count(array_intersect($option_role_codes, [$role])) == 0) {
                $product->options->forget($i);
            }
        }

        return view('product/webinars/show', [
            'product' => $product,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Educational Webinars' => '/webinars',
                "{$product->name}" => "/webinars/{$product->id}"
            ]
        ]);
    }

}
