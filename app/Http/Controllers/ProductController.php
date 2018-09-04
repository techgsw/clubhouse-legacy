<?php

namespace App\Http\Controllers;

use \Exception;
use App\Message;
use App\Product;
use App\ProductOption;
use App\ProductOptionRole;
use App\Tag;
// TODO use App\Http\Requests\StoreProduct;
// TODO use App\Http\Requests\UpdateProduct;
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
                foreach ($product->options as $opt) {
                    $options[$opt->id] = $opt;
                }

                foreach (request('option') as $i => $params) {
                    if ($params['id']) {
                        $option = $options[$params['id']] ?: new ProductOption;
                    } else {
                        $option = new ProductOption;
                    }
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

                    // Remove option from options array so that it doesn't get deleted
                    unset($options[$params['id']]);
                }

                // Delete options that are not posted
                foreach ($options as $id => $opt) {
                    ProductOptionRole::where('product_option_id', $id)->delete();
                    $opt->delete();
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

                foreach ($product->options as $key => $option) {
                    if ($product->type == 'service') {
                        StripeServiceProvider::updatePlan($option);
                    } else {
                        StripeServiceProvider::updateSku($option);
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

        return view('product/show', [
            'product' => $product,
            'breadcrumb' => [
                'Clubhouse' => '/',
                "{$product->name}" => "/product/{$product->id}"
            ]
        ]);
    }

    public function careerServices()
    {
        $products = Product::with('tags')->whereHas('tags', function ($query) {
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
        $this->authorize('view-product');

        $product = Product::with('options.roles')->where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        // TODO make this resource-driven
        $role = 'user';
        foreach (Auth::user()->roles as $r) {
            if ($r->code == 'clubhouse') {
                $role = 'clubhouse';
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
        $products = Product::with('tags')->whereHas('tags', function ($query) {
            $query->where('name', 'Webinar');
        })->get();

        return view('product/webinars', [
            'products' => $products,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Webinars' => '/webinars'
            ]
        ]);
    }

    public function showWebinars($id)
    {
        $this->authorize('view-product');

        $product = Product::with('options.roles')->where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        // TODO make this resource-driven
        $role = 'user';
        foreach (Auth::user()->roles as $r) {
            if ($r->code == 'clubhouse') {
                $role = 'clubhouse';
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
                'Webinars' => '/webinars',
                "{$product->name}" => "/webinars/{$product->id}"
            ]
        ]);
    }
}
