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
                @can ('edit-post', $post)
                    <div style="text-align: right;">
                        <a href="/post/{{ $post->title_url }}/edit" class="flat-button blue small"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                @endif
                <div class="tag-list" style="margin-bottom: 12px;">
                    @foreach ($post->tags as $tag)
                        <a href="/blog?tag={{ $tag->slug }}" class="flat-button gray small" style="display: inline-block; margin: 2px;">{{ ucfirst($tag->name) }}</a>
                    @endforeach
                </div>
                <h2 class="title">{{ $post->title }}</h2>
                <div style="margin-bottom: 10px;">
                    <a class="no-underline" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fsportsbusiness.solutions%2Fblog%2F<?=urlencode($post->title_url)?>"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                    <a class="no-underline" target="_blank" href="https://twitter.com/intent/tweet?text=<?=urlencode('https://sportsbusiness.solutions/blog/'.$post->title_url)?>"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                    <a class="no-underline" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?=urlencode('https://sportsbusiness.solutions/blog/'.$post->title_url)?>&title=<?=$post->title?>&summary=<?=substr($meta_body, 0, $index)?>&source=Sports Business Solutions')?>"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                    <a class="no-underline" target="_blank" href="mailto:?Subject=<?=$post->title?> | Sports Business Solutions&body=<?=urlencode('https://sportsbusiness.solutions/blog/'.$post->title_url)?>"><i class="fa fa-envelope-square fa-16x" aria-hidden="true"></i></a>
                </div>
                <p class="small light uppercase">by <?=(($post->authored_by) ?: $post->user->first_name.' '.$post->user->last_name)?> | {{ $post->created_at->format('F d, Y') }}</p>
                @php
                    $image_path = $post->getImagePath($post->images->where('image_order', 1)->first());
                @endphp
                @if ($image_path)
                    <p class="hide-on-med-and-up" style="text-align: center;">
                        <img style="width: 85%; max-height: auto; box-shadow: 2px 2px #F2F2F2;" src={{ Storage::disk('local')->url($image_path) }} />
                    </p>
                    <p class="hide-on-small-only" style="float: left; margin-right: 20px; margin-top: 5px;">
                        <img style="width: auto; max-height: 300px; box-shadow: 2px 2px #F2F2F2;" src={{ Storage::disk('local')->url($image_path) }} />
                    </p>
                @endif
                {!! $body !!}
            </div>
        </div>
    </div>
</div>
@if ($post->user->id === 1 && is_null($post->authored_by))
    @include('post.signatures.bob-hamer')
@elseif ($post->user->id === 7 && is_null($post->authored_by))
    @include('post.signatures.mike-rudner')
@endif
@endsection
