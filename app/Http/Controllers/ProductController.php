<?php

namespace App\Http\Controllers;

use \Exception;
use Mail;
use App\Message;
use App\Product;
use App\ProductOption;
use App\ProductOptionRole;
use App\Tag;
use App\Transaction;
use App\TransactionProductOption;
use App\Mail\UserPaidWebinar;
use App\Providers\ImageServiceProvider;
use App\Providers\StripeServiceProvider;
use App\Providers\EmailServiceProvider;
use App\Providers\ZoomServiceProvider;
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

        $training_video_options = ProductOption::whereHas('product.tags', function($query) {
            $query->where('name', 'Training Video');
        })->distinct()->get(['name', 'description']);

        $training_video_book_chapter_map = array();

        foreach($training_video_options as $option) {
           $training_video_book_chapter_map[$option->name] []= $option->description;
        }

        return view('product/create', [
            'training_video_book_chapter_map' => $training_video_book_chapter_map,
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
                $product_type = null;
                $product = new Product;
                $product->name = request('name');
                $product->description = request('description');
                $product->active = request('active') ? true : false;
                $product->type = request('type') ? 'service' : 'good';

                if (count(request('option')) > 0) {
                    $product->highest_option_role = 'guest';
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
                            $product->highest_option_role = 'clubhouse';
                            $roles[] = 'clubhouse';
                        }
                        if (array_key_exists('user', $params)) {
                            if ($product->highest_option_role != 'clubhouse') {
                                $product->highest_option_role = 'user';
                            }
                            $roles[] = 'user';
                        }
                        $option->roles()->sync($roles);
                    }
                }

                $product->save();

                $image_file = request()->file('image_url');
                if ($image_file) {
                    $image = ImageServiceProvider::saveFileAsImage(
                        $image_file,
                        $filename = preg_replace('/(?:\s|#)/', '-', str_replace("/", "", $product->name)).'-SportsBusinessSolutions',
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

                $webinar_tag = false;
                if (in_array('Webinar', $tag_names) || in_array('#SameHere', $tag_names)) {
                    $webinar_tag = true;
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
                            if ($option->price > 0) {
                                $stripe_sku = StripeServiceProvider::createSku($stripe_product, $option);
                                $option->stripe_sku_id = $stripe_sku->id;
                            }
                            if ($webinar_tag == true) {
                                if (!preg_match('/^\d+:?\d*[(am)|(pm)]+\s[A-z]+/i', $option->description)) {
                                    throw new Exception('Invalid Webinar description. Format must be T[am|pm] [GMT|PST|EST]');
                                }
                                $date = new \DateTime($option->name . ' ' . preg_replace('/ [A-z]+/', '', $option->description));
                                $webinar = ZoomServiceProvider::createWebinar($product->name, $product->description, $date, true);
                                $option->zoom_webinar_id = $webinar->id;
                            }
                            $option->save();
                        } catch (Exception $e) {
                            Log::error($e);
                            if (!is_null($stripe_product)) {
                                StripeServiceProvider::deleteProduct($stripe_product);
                            }
                            if (isset($stripe_sku)) {
                                StripeServiceProvider::deleteSku($stripe_sku);
                            }
                            throw new Exception('Unable to update product option with stripe sku id or zoom id', 0, $e);
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

        $training_video_options = ProductOption::whereHas('product.tags', function($query) {
            $query->where('name', 'Training Video');
        })->distinct()->get(['name', 'description']);

        $training_video_book_chapter_map = array();

        foreach($training_video_options as $option) {
            $training_video_book_chapter_map[$option->name] []= $option->description;
        }

        return view('product/edit', [
            'product' => $product,
            'product_tags_json' => $product_tags_json,
            'training_video_book_chapter_map' => $training_video_book_chapter_map,
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

                $options = [];
                $updated_options = [];
                foreach ($product->options as $opt) {
                    $options[$opt->id] = $opt;
                }

                if (count(request('option')) > 0) {
                    $product->highest_option_role = 'guest';
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
                            $product->highest_option_role = 'clubhouse';
                            $roles[] = 'clubhouse';
                        }
                        if (array_key_exists('user', $params)) {
                            if ($product->highest_option_role != 'clubhouse') {
                                $product->highest_option_role = 'user';
                            }
                            $roles[] = 'user';
                        }
                        $option->roles()->sync($roles);

                        // Remove option from options array so that it doesn't get deleted
                        $updated_options[$option->id] = $option;
                        unset($options[$params['id']]);
                    }
                }

                $product->save();

                $image_file = request()->file('image_url');
                if ($image_file) {
                    $image = ImageServiceProvider::saveFileAsImage(
                        $image_file,
                        $filename = preg_replace('/(?:\s|#)/', '-', str_replace("/", "", $product->name)).'-SportsBusinessSolutions',
                        $directory = 'product/'.$product->id
                    );
                    $product->images()->detach();
                    $product->images()->attach($image->id);
                }

                $tag_json = request('product_tags_json');
                $tag_names = json_decode($tag_json);
                $product->tags()->sync($tag_names);

                // Delete options that are not posted
                foreach ($options as $id => $opt) {
                    ProductOptionRole::where('product_option_id', $id)->delete();
                    $opt->delete();

                    if ($product->type == 'service') {
                        StripeServiceProvider::deletePlan($opt);
                    }
                }

                $stripe_product = StripeServiceProvider::updateProduct($product);

                $webinar_tag = false;
                if (in_array('Webinar', $tag_names) || in_array('#SameHere', $tag_names)) {
                    $webinar_tag = true;
                }

                foreach ($updated_options as $key => $option) {
                    if ($product->type == 'service') {
                        $stripe_plan = StripeServiceProvider::updatePlan($stripe_product, $option);
                        $option->stripe_plan_id = $stripe_plan->id;
                    } else {
                        if ($option->price > 0) {
                            $stripe_sku = StripeServiceProvider::updateSku($stripe_product, $option);
                            $option->stripe_sku_id = $stripe_sku->id;
                        } else {
                            if ($webinar_tag == true && is_null($option->zoom_webinar_id)) {
                                if (!preg_match('/^\d+:?\d*[(am)|(pm)]+\s[A-z]+/i', $option->description)) {
                                    throw new Exception('Invalid webinar description. Format must be T[am|pm] [GMT|PST|EST]');
                                }
                                $date = new \DateTime($option->name . ' ' . preg_replace('/ [A-z]+/', '', $option->description));
                                $webinar = ZoomServiceProvider::createWebinar($product->name, $product->description, $date, false);
                                $option->zoom_webinar_id = $webinar->id;
                            }
                        }
                    }
                    $option->save();
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

    public function webinars(Request $request)
    {
        // TODO Need a way to delete products, webinars, etc. Currently hiding product id 53
        $inactive_products_query = Product::with('tags')
            ->where('active', false)->where('id', '!=', 53)
            ->whereHas('tags', function ($query) {
                $query->whereIn('name', array('Webinar', '#SameHere'));
            });

        $active_tag = null;
        $active_products = null;
        if ($request->tag) {
            $inactive_products_query = $inactive_products_query->whereHas('tags', function ($query) use ($request)  {
                $query->where('slug', $request->tag);
            });
            $results = Tag::where('slug', $request->tag)->get();
            if (count($results) > 0) {
                $active_tag = $results[0];
            }
        } else {
            // Only show active products when there's no tag search
            $active_products = Product::where('active', true)->with('tags')->whereHas('tags', function ($query) {
                $query->whereIn('name', array('Webinar', '#SameHere'));
            })->get();
        }

        $inactive_products = $inactive_products_query
            ->orderByRaw("FIELD(highest_option_role, 'guest', 'user', 'clubhouse')")
            ->orderBy('id', 'desc')
            ->paginate(30);

        $tags = Tag::join('product_tag', function($join) {
            $join->on('name', 'tag_name')
                ->where('name', '!=', 'webinar')
                // using raw query because of https://github.com/laravel/framework/issues/19695
                ->whereRaw("product_id IN (SELECT product_id FROM product_tag WHERE tag_name in ('webinar', '#SameHere'))");
        })->whereHas('products', function ($query) {
            $query->where('active', false);
        })->orderBy('name', 'dec')->get()->keyBy('name');

        return view('product/webinars', [
            'active_products' => $active_products,
            'inactive_products' => $inactive_products,
            'active_tag' => $active_tag,
            'tags' => $tags,
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

        return view('product/webinars/show', [
            'product' => $product,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Educational Webinars' => '/webinars',
                "{$product->name}" => "/webinars/{$product->id}"
            ]
        ]);
    }

    public function trainingVideos(Request $request)
    {
        $active_tag = null;
        $active_author = null;

        if ($request->book) {
            if ($request->chapter) {
                // Get a list of training videos for the current chapter

                $training_videos = Product::where('active', true)->with('tags')->whereHas('tags', function ($query) {
                    $query->where('name', 'Training Video');
                })->with('options')->whereHas('options', function($query) use ($request) {
                    $query->where('name', $request->book)->where('description', $request->chapter);
                })->orderBy('created_at', 'DESC')->paginate(10);

                return view('/product/training-videos/by-chapter', [
                    'training_videos' => $training_videos,
                    'book' => $request->book,
                    'chapter' => $request->chapter,
                    'breadcrumb' => [
                        'Clubhouse' => '/',
                        'Sport Sales Vault' => '/sales-vault/',
                        'Training Videos' => '/sales-vault/training-videos',
                        $request->book => "/sales-vault/training-videos?book={$request->book}",
                        $request->chapter => "/sales-vault/training-videos?book={$request->book}?chapter={$request->chapter}",
                    ]
                ]);
            } else {
                // Get a list of chapters for the book and the latest 5 training videos of each

                $training_videos_by_chapter = ProductOption::where('name', $request->book)->whereHas('product', function ($query) {
                    $query->where('active', true);
                })->distinct()->get(['description'])->keyBy('description');

                foreach ($training_videos_by_chapter as $chapter => $videos) {
                    $training_videos_by_chapter[$chapter] = Product::where('active', true)->with('tags')->whereHas('tags', function ($query) {
                        $query->where('name', 'Training Video');
                    })->with('options')->whereHas('options', function($query) use ($request, $chapter) {
                        $query->where('name', $request->book)->where('description', $chapter);
                    })->orderBy('created_at', 'DESC')->limit(5)->get();
                }

                $books = ProductOption::whereHas('product.tags', function($query) {
                    $query->where('name', 'Training Video');
                })->distinct()->get(['name']);

                return view('/product/training-videos/by-book', [
                    'training_videos_by_chapter' => $training_videos_by_chapter,
                    'books' => $books,
                    'book' => $request->book,
                    'breadcrumb' => [
                        'Clubhouse' => '/',
                        'Sport Sales Vault' => '/sales-vault/',
                        'Training Videos' => '/sales-vault/training-videos',
                        $request->book => "/sales-vault/training-videos?book={$request->book}",
                    ]
                ]);
            }
        } else {
            $products_query = Product::where('active', true)->with('tags')->whereHas('tags', function ($query) {
                $query->where('name', 'Training Video');
            });

            if ($request->tag) {
                $products_query = $products_query->whereHas('tags', function ($query) use ($request)  {
                    $query->where('slug', $request->tag);
                });
                $results = Tag::where('slug', $request->tag)->get();
                if (count($results) > 0) {
                    $active_tag = $results[0];
                }
            } else if ($request->author) {
                $products_query = $products_query->whereHas('tags', function ($query) use ($request)  {
                    $query->whereRaw("UPPER(name) LIKE '%AUTHOR:".strtoupper($request->author)."%'");
                });
                $results = Tag::whereRaw("UPPER(name) LIKE '%AUTHOR:".strtoupper($request->author)."%'")->get();
                if (count($results) > 0) {
                    $active_author = $results[0];
                }
            }

            $books = ProductOption::whereHas('product.tags', function($query) {
                $query->where('name', 'Training Video');
            })->distinct()->get(['name']);

            $authors = Tag::join('product_tag', function($join) {
                $join->on('name', 'tag_name')
                    ->whereRaw("UPPER(tag_name) LIKE '%AUTHOR:%'")
                    // using raw query because of https://github.com/laravel/framework/issues/19695
                    ->whereRaw("product_id IN (SELECT product_id FROM product_tag WHERE tag_name = 'Training Video')");
            })->distinct()->get(['name']);

            $videos = $products_query->orderBy('created_at', 'DESC')->paginate(10);

            return view('/product/training-videos/training-videos', [
                'videos' => $videos,
                'books' => $books,
                'authors' => $authors,
                'active_tag' => $active_tag,
                'active_author' => $active_author,
                'breadcrumb' => [
                    'Clubhouse' => '/',
                    'Sport Sales Vault' => '/sales-vault/',
                    'Training Videos' => '/sales-vault/training-videos'
                ]
            ]);
        }
    }

    public function showTrainingVideo($id)
    {
        //TODO: if we ever add prices to this we'll need to know which section this is coming from,
        // because technically both options can have different prices

        $video = Product::with('options.roles')->where('id', $id)
            ->whereHas('tags', function ($query) {
                $query->where('name', 'Training Video');
            })->first();

        if (!$video) {
            return redirect()->back()->withErrors(['msg' => 'Could not find training video ' . $id]);
        }

        $option = $video->options->first();

        return view('/product/training-videos/show', [
            'video' => $video,
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Sport Sales Vault' => '/sales-vault/',
                'Training Videos' => '/sales-vault/training-videos',
                $option->name => "/sales-vault/training-videos?book={$option->name}",
                $option->description => "/sales-vault/training-videos?book={$option->name}&chapter={$option->description}",
                $video->name => "/sales-vault/training-videos/{$video->id}"
            ]
        ]);
    }

    public function getTrainingVideoChaptersForAutocomplete()
    {
        return response()->json([
            'chapters' => ProductOption::whereHas('product.tags', function($query) {
                $query->where('name', 'Training Video');
            })->distinct()->get(['name as book', 'description as name'])
        ]);
    }

}
