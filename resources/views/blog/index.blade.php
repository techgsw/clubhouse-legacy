<!-- /resources/views/blog/index.blade.php -->
@extends('layouts.default')
@section('title', 'Blog')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h3>Blog</h3>
            @foreach ($posts as $post)
                <div>
                    <a href="/post/{{ $post->id }}">
                        <h5>{{ $post->title }}</h5>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
