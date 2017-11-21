<!-- /resources/views/post/show.blade.php -->
@extends('layouts.default')
@section('title', $post->title)
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12 m9 l10">
            <div class="blog-post">
                <h2 class="title">{{ $post->title }}</h2>
                {!! $body !!}
            </div>
        </div>
        <div class="col s12 m3 l2">
            @if (true) <!-- TODO can (edit-post) -->
                <div>
                    <a href="/post/{{ $post->id }}/edit" class="flat-button blue small"><i class="fa fa-pencil"></i> Edit</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
