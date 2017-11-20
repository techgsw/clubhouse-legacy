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
                    <h4>{{ $post->title }}</h4>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
