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

        //TODO: pull latest three same_here posts
        //TODO: pull latest two webinars

        //TODO: discussion board specifics

        return view('same-here/index', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                '#SameHere' => '/same-here'
            ]
        ]);
    }

    public function blog(Request $request)
    {
        $request->request->add(array('tag' => '#SameHere'));
        $posts = Post::search($request)->where('post_type_code', 'blog')->paginate(15);
        $tags = Tag::has('posts')->orderBy('name', 'dec')->get();

        $tag = null;
        if ($request->tag) {
            $results = Tag::where('slug', $request->tag)->get();
            if (count($results) > 0) {
                $tag = $results[0];
            }
        }

        return view('blog/index', [
            'breadcrumb' => [
                'Clubhouse' => '/',
                'Sports Industry Blog' => '/blog'
            ],
            'posts' => $posts,
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
