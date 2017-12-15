<!-- /resources/views/post/show.blade.php -->
@extends('layouts.default')
@section('title', strip_tags($post->title))
@php 
    // TODO I'm sure this could be more elegant.
    $parsedown = new Parsedown();
    $meta_body = strip_tags($parsedown->text($post->body));
    $post_length = strlen($body);
    $index = 200; 
@endphp
@if ($post_length > $index)
    @while (!preg_match('/\s/', $meta_body[$index]) && $post_length > $index)
    @php $index++; @endphp
    @endwhile
    
    @section('description', substr($meta_body, 0, $index).'...')
@else
    @section('description', $meta_body)
@endif
@section('url', Request::fullUrl())
@if (preg_match('/\/images\/legacy\/uploads\//', $post->image_url))
    @section('image', url('/').str_replace('medium', 'share', $post->image_url))
@else
    @section('image', url('/').Storage::disk('local')->url(str_replace('medium', 'share', $post->image_url)))
@endif
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
                @if (true) <!-- TODO can (edit-post) -->
                    <div style="text-align: right;">
                        <a href="/post/{{ $post->title_url }}/edit" class="flat-button blue small"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                @endif
                <div class="tag-list" style="margin-top: -10px; margin-bottom: 20px;">
                    @foreach ($post->tags as $tag)
                        <a href="/blog?tag={{ $tag->slug }}" class="flat-button gray small" style="display: inline-block; margin: 2px;">{{ $tag->name }}</a>
                    @endforeach
                </div>
                <h2 class="title">{{ $post->title }}</h2>
                <p class="small light uppercase">by {{ $post->user->first_name }} {{ $post->user->last_name }} | {{ $post->created_at->format('F d, Y') }}</p>
                @if ($post->image_url)
                    <p class="hide-on-med-and-up" style="text-align: center;">
                        @if (preg_match('/\/images\/legacy\/uploads\//', $post->image_url))
                            <img style="width: 85%; max-height: auto; box-shadow: 2px 2px #F2F2F2;" src="{{ $post->image_url }}" alt="">
                        @else
                            <img style="width: 85%; max-height: auto; box-shadow: 2px 2px #F2F2F2;" src={{ Storage::disk('local')->url($post->image_url) }} />
                        @endif
                    </p>
                    <p class="hide-on-small-only" style="float: left; margin-right: 20px; margin-top: 5px;">
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
