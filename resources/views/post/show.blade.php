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
@if ($image_path && !is_null($image))
    @section ('hero')
        <div class="row hero" style="max-width:1100px;height:450px;background-image: url({{$image->getUrl('share')}});background-position: center; background-repeat: no-repeat;">
        </div>
    @endsection
@endif
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
                    <div style="float: right;">
                        <a href="/post/{{ $post->title_url }}/edit" class="flat-button blue small"><i class="fa fa-pencil"></i> Edit</a>
                    </div>
                @endif
                <h1 class="title">{{ $post->title }}</h1>
                <p class="author">by <?=(($post->authored_by) ?: $post->user->first_name.' '.$post->user->last_name)?> <br> {{ $post->created_at->format('F d, Y') }}</p>
                <div style="font-size:16px;">
                    {!! $body !!}
                </div>
                <div class="row">
                    <div class="col s12 center-align">
                        <a href="{{env('APP_URL')}}" class="btn sbs-red blog-cta" style="line-height:20px;">Sports Business Solutions for C-Level and VP Level Execs</a>
                        <a href="{{env('CLUBHOUSE_URL')}}" class="btn sbs-red blog-cta" style="line-height:20px;">Grow your professional sports career in theClubhouse</a>
                        <a href="mailto:bob@sportsbusiness.solutions" class="btn sbs-red blog-cta">Contact Bob Hamer</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="tag-list" style="float:right;">
                            @foreach ($post->tags as $tag)
                                <a href="{{$context == 'same-here' ? '/same-here' : ''}}/blog?tag={{ urlencode($tag->slug) }}" class="flat-button gray small" style="display: inline-block; margin: 2px;">{{ ucfirst($tag->name) }}</a>
                            @endforeach
                        </div>
                        <div style="margin-right: 10px;float:right;">
                            <a class="no-underline" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?=urlencode('https://clubhouse.sportsbusiness.solutions/blog/'.$post->title_url)?>&title=<?=htmlspecialchars($post->title)?>&summary=<?=substr($meta_body, 0, $index)?>&source=Sports Business Solutions')?>"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                            <a class="no-underline" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fclubhouse.sportsbusiness.solutions%2Fblog%2F<?=urlencode(htmlspecialchars($post->title_url))?>"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                            <a class="no-underline" target="_blank" href="https://twitter.com/intent/tweet?text=<?=urlencode('https://clubhouse.sportsbusiness.solutions/blog/'.htmlspecialchars($post->title_url))?>"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                            <a class="no-underline" href="mailto:?Subject=<?=$post->title?> | Sports Business Solutions&body=<?=urlencode('https://clubhouse.sportsbusiness.solutions/blog/'.$post->title_url)?>"><i class="fa fa-envelope-square fa-16x" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
