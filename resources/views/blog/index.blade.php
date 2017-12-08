<!-- /resources/views/blog/index.blade.php -->
@extends('layouts.default')
@section('title', 'Blog')
@section('hero')
    <div class="row hero bg-image blog">
        <div class="col s12">
            <h4 class="header">Sports Business Blog</h4>
            <p>Knowledge is power and we believe in sharing our industry knowledge to help you succeed.</p>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12 m8 l9 blog-list">
            @foreach ($posts as $post)
                <div class="blog-list-item">
                    <div class="row">
                        <div class="col s4 m3">
                            <a href="/post/{{ $post->title_url}}" class="no-underline">
                                <img src="{{ $post->image_url }}" alt="">
                            </a>
                        </div>
                        <div class="col s8 m9">
                            <h5>{{ $post->title }}</h5>
                            <p class="small light uppercase">by {{ $post->user->first_name }} {{ $post->user->last_name }}</p>
                            <p>This is the post preview bit. I think it should be set per-post, rather than just pulling the first few words. What do you think?</p>
                            <a href="/post/{{ $post->title_url }}" class="btn sbs-red"> Read more</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col hide-on-small-only m4 l3">
            <!-- Search -->
            <form action="/blog" method="get">
                <div class="input-field">
                    <input id="search" type="text" name="search" value="">
                    <label for="search">Search</label>
                </div>
            </form>
            <!-- Tags -->
            <div class="tag-cloud">
                @foreach ($tags as $tag)
                    <a href="/blog" class="flat-button black" style="display: inline-block; margin: 4px;">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
<style type="text/css" media="screen">
    .blog-list .blog-list-item {
        padding: 12px 0;
    }
</style>
