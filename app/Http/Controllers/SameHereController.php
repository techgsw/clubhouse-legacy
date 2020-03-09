<?php

namespace App\Http\Controllers;

use App\Post;
use App\Product;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SameHereController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::where('post_type_code', 'blog')->whereHas('tags', function ($query) {
            $query->where('name', '#SameHere');
            $query->where('post_type_code', 'blog');
        })->orderBy('id', 'DESC')->limit(3)->get();

        $webinars = Product::where('active', true)->with('options')->whereHas('tags', function ($query) {
            $query->where('name', '#SameHere');
        })->orderBy('id', 'DESC')->limit(2)->get();

        //TODO: discussion board specifics

        return view('same-here/index', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                '#SameHere' => '/same-here'
            ],
            'posts' => $posts,
            'webinars' => $webinars
        ]);
    }

    public function blog(Request $request)
    {
        $tag = null;
        if ($request->tag) {
            $results = Tag::where('slug', $request->tag)->get();
            if (count($results) > 0) {
                $tag = $results[0];
            }
        }

        // add the #SameHere tag to the request after we've checked for specific tags the user is searching for
        $posts = Post::search($request)->whereHas('tags', function ($query) {
            $query->where('name', '#SameHere');
            $query->where('post_type_code', 'blog');
        })->where('post_type_code', 'blog')->paginate(15);
        $tags = Tag::join('post_tag', function($join) {
            $join->on('name', 'tag_name')
                // using raw query because of https://github.com/laravel/framework/issues/19695
                ->whereRaw("post_id IN (SELECT post_id FROM post_tag WHERE tag_name = '#SameHere')");
        })->orderBy('name', 'dec')->get()->keyBy('name');

        return view('same-here/blog', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                '#SameHere' => '/same-here',
                '#SameHere Solutions Blog' => '/same-here/blog'
            ],
            'posts' => $posts,
            'tags' => $tags,
            'result_tag' => $tag
        ]);
    }

    public function webinars(Request $request)
    {
        $inactive_products_query = Product::where('active', false)->with('tags')->whereHas('tags', function ($query) {
            $query->where('name', '#SameHere');
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
                $query->where('name', '#SameHere');
            })->get();
        }

        $inactive_products = $inactive_products_query->orderBy('id', 'desc')->paginate(5);

        $tags = Tag::join('product_tag', function($join) {
            $join->on('name', 'tag_name')
                ->where('name', '!=', 'webinar')
                // using raw query because of https://github.com/laravel/framework/issues/19695
                ->whereRaw("product_id IN (SELECT product_id FROM product_tag WHERE tag_name = '#SameHere')");
        })->orderBy('name', 'dec')->get()->keyBy('name');

        return view('same-here/webinars', [
            'active_products' => $active_products,
            'inactive_products' => $inactive_products,
            'active_tag' => $active_tag,
            'tags' => $tags,
            'breadcrumb' => [
                'Clubhouse' => '/',
                '#SameHere' => '/same-here',
                'Mental Health Discussions' => '/same-here/webinars'
            ]
        ]);
    }

    public function showWebinars($id)
    {
        $product = Product::with('options')->where('id', $id)->first();
        if (!$product) {
            return redirect()->back()->withErrors(['msg' => 'Could not find product ' . $id]);
        }

        return view('same-here/webinars/show', [
            'product' => $product,
            'breadcrumb' => [
                'Clubhouse' => '/',
                '#SameHere' => '/same-here',
                'Mental Health Discussions' => '/same-here/webinars',
                "{$product->name}" => "/same-here/webinars/{$product->id}"
            ]
        ]);
    }

}
