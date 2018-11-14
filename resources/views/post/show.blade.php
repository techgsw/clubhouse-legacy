<!-- /resources/views/post/show.blade.php -->
@extends('layouts.clubhouse')
@section('title', strip_tags($post->title))
@php
    // TODO I'm sure this could be more elegant.
    $parsedown = new Parsedown();
    $meta_body = strip_tags($parsedown->text($post->body));
    $post_length = strlen($body);
    $index = 200;
    $image = $post->images->first();
    if (!is_null($image)) {
        $image_path = $image->getURL();
    } else {
        $image_path = null;
    }
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
@if ($image_path)
    @section('image', $image->cdn ? $image->getURL('share') : url('/').$image->getURL('share'))
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
                    <a class="no-underline" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fclubhouse.sportsbusiness.solutions%2Fblog%2F<?=urlencode($post->title_url)?>"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                    <a class="no-underline" target="_blank" href="https://twitter.com/intent/tweet?text=<?=urlencode('https://clubhouse.sportsbusiness.solutions/blog/'.$post->title_url)?>"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                    <a class="no-underline" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?=urlencode('https://clubhouse.sportsbusiness.solutions/blog/'.$post->title_url)?>&title=<?=$post->title?>&summary=<?=substr($meta_body, 0, $index)?>&source=Sports Business Solutions')?>"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                    <a class="no-underline" href="mailto:?Subject=<?=$post->title?> | Sports Business Solutions&body=<?=urlencode('https://clubhouse.sportsbusiness.solutions/blog/'.$post->title_url)?>"><i class="fa fa-envelope-square fa-16x" aria-hidden="true"></i></a>
                </div>
                <p class="small light uppercase">by <?=(($post->authored_by) ?: $post->user->first_name.' '.$post->user->last_name)?> | {{ $post->created_at->format('F d, Y') }}</p>
                @if ($image_path && !is_null($image))
                    <p class="hide-on-med-and-up" style="text-align: center;">
                        <img style="width: 85%; max-height: auto; box-shadow: 2px 2px #F2F2F2;" src={{ $image->getURL() }} />
                    </p>
                    <p class="hide-on-small-only" style="float: left; margin-right: 20px; margin-top: 5px;">
                        <img style="width: auto; max-height: 300px; box-shadow: 2px 2px #F2F2F2;" src={{ $image->getURL() }} />
                    </p>
                @endif
                {!! $body !!}
            </div>
        </div>
    </div>
</div>
@endsection
