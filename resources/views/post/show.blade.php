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
        <div class="col s12">
            <div class="blog-post">
                <div class="tag-list" style="margin-top: -10px; margin-bottom: 20px;">
                    @if (true) <!-- TODO can (edit-post) -->
                        <div style="float: right;">
                            <a href="/post/{{ $post->title_url }}/edit" class="flat-button blue small"><i class="fa fa-pencil"></i> Edit</a>
                        </div>
                    @endif
                    @foreach ($post->tags as $tag)
                        <a href="/blog?tag={{ $tag->slug }}" class="flat-button gray small" style="display: inline-block; margin: 2px;">{{ $tag->name }}</a>
                    @endforeach
                </div>
                <h2 class="title">{{ $post->title }}</h2>
                <p class="small light uppercase">by {{ $post->user->first_name }} {{ $post->user->last_name }}</p>
                @if ($post->image_url)
                    <p style="float: left; margin-right: 20px;">
                        @if (preg_match('/\/images\/legacy\/uploads\//', $post->image_url))
                            <img style="width: auto; max-height: 300px; box-shadow: 2px 2px #F2F2F2;" src="{{ $post->image_url }}" alt="">
                        @else
                            <img style="width: auto; max-height: 300px; box-shadow: 2px 2px #F2F2F2;" src={{ Storage::disk('local')->url($post->image_url) }} />
                        @endif
                    </p>
                @endif
                {!! $body !!}
            </div>
        </div>
    </div>
</div>
@endsection
