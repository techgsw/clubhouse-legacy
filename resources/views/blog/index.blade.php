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
        <div class="col s12 blog-list">
            @foreach ($posts as $post)
                <div class="blog-list-item">
                    <a href="/post/{{ $post->id }}">
                        <h5>{{ $post->title }}</h5>
                        <a href="/post/{{ $post->id }}" class="btn sbs-red"> Read more</a>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
<style type="text/css" media="screen">
    .blog-list .blog-list-item {
        padding: 12px 0;
    }
</style>
