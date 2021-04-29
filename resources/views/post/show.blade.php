<!-- /resources/views/post/show.blade.php -->
@extends('layouts.clubhouse')
@section('title', strip_tags($post->title))
@section('additional-fonts')
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans+Condensed:wght@300" rel="stylesheet">
@endsection
@php
    // TODO I'm sure this could be more elegant.
    $meta_body = strip_tags($body);
    $body = str_replace('[caption]', '<span class="blog-caption">', $body);
    $body = str_replace('[/caption]', '</span>', $body);
    $post_length = strlen($body);
    $index = 200;
    $image = $post->getPrimaryImage();
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
    @section('image-alt', $image->pivot->alt)
@endif
@section('title', $post->title)
@section('hero')
<div class="container" style="position:relative;margin-bottom: -35px;max-width:1270px;">
    <div class="blog-sidebar" style="text-align:center;">
        <!-- TODO: this div is a hack to make position:sticky work. if elements are added to the sidebar then margin-bottom will need to be changed. we should grab the sidebar height using jquery -->
        <div style="height:100%;margin-bottom:-1000px;"></div>
        <div class="sidebar-content" style="position:sticky;position:-webkit-sticky;bottom:1rem;">
            <a class="no-underline clubhouse-logo" href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}"><img style="width:75px" src="/images/CH_logo-compass.png"/></a>
            <p><a class="no-underline" target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}/career-services">Career Services</a></p>
            <hr>
            <p><a class="no-underline" target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}/webinars">Webinars</a></p>
            <hr>
            <p><a class="no-underline" target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}/mentor">Industry Mentorship</a></p>
            <hr>
            <p><a class="no-underline" target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}/job">Jobs in Sports</a></p>
            <hr>
            <p><a class="no-underline" target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}/sales-vault">Sales Training</a></p>
            <a class="no-underline clubhouse-logo" href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}"><img style="width:75px" src="/images/CH_logo-compass.png"/></a>
            <br>
            <p><a class="no-underline" href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}"><strong>Become a Clubhouse PRO Member</strong></a></p>
            <br>
            <p>{{CLUBHOUSE_FREE_TRIAL_DAYS}}-day free trial</p>
            <br>
            <!--TODO: pull in option 1 price -->
            <p>$7/month</p>
            <br>
            <a target="_blank" rel="noopener" href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" style="height:80px;padding:20px;line-height: 20px;" class="btn sbs-red">Subscribe Now</a>
        </div>
    </div>
    <div class="blog-image">
        @if (!is_null($image))
            <img src="{{$image->getUrl('share')}}" alt="{{$image->pivot->alt}}"/>
        @endif
    </div>
    @if (!is_null($image))
        <span class="blog-caption">{{$image->pivot->caption}}</span>
    @endif
    <div class="blog-content">
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
                    <p class="author">by {{$post->authored_by ?: $post->user->first_name.' '.$post->user->last_name}} <br> {{ $post->created_at->format('F d, Y') }}</p>
                    <div class="blog-post-body" style="font-size:16px;">
                        {!! $body !!}
                    </div>
                    <div class="row" style="margin-top:30px;margin-bottom: 20px;">
                        <div class="col s12 center-align">
                            <div class="tag-list">
                                @foreach ($post->tags as $tag)
                                    <a href="/blog?tag={{ urlencode($tag->slug) }}" class="flat-button gray" style="display: inline-block; margin: 2px;">{{ ucfirst($tag->name) }}</a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col s12 center-align" style="margin-top:20px;">
                            <div>
                                <a class="no-underline" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?=urlencode('https://clubhouse.sportsbusiness.solutions/blog/'.$post->title_url)?>&title=<?=htmlspecialchars($post->title)?>&summary=<?=substr($meta_body, 0, $index)?>&source=SBS Consulting')?>"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                                <a class="no-underline" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fclubhouse.sportsbusiness.solutions%2Fblog%2F<?=urlencode(htmlspecialchars($post->title_url))?>"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                                <a class="no-underline" target="_blank" href="https://twitter.com/intent/tweet?text=<?=urlencode('https://clubhouse.sportsbusiness.solutions/blog/'.htmlspecialchars($post->title_url))?>"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                                <a class="no-underline" href="mailto:?Subject=<?=$post->title?> | SBS Consulting&body=<?=urlencode('https://clubhouse.sportsbusiness.solutions/blog/'.$post->title_url)?>"><i class="fa fa-envelope-square fa-16x" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 30px;">
                        <div class="col s12 center-align">
                            <a href="{{env('APP_URL')}}" class="btn sbs-red blog-cta" style="line-height:20px;">SBS Consulting for Training | Consulting | Recruiting</a>
                            <a target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}" class="btn sbs-red blog-cta" style="line-height:20px;">Grow your professional sports career in theClubhouse<sup>&#174;</sup></a>
                            <a href="mailto:bob@sportsbusiness.solutions" class="btn sbs-red blog-cta">Contact Bob Hamer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="blog-sidebar sidebar-mobile">
        <a class="no-underline clubhouse-logo" href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}"><img style="width:75px" src="/images/CH_logo-compass.png"/></a>
        <p><a class="no-underline" target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}/career-services">Career Services</a>
           <strong class="sbs-red-text">|</strong> 
           <a class="no-underline" target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}/webinars">Webinars</a> 
           <strong class="sbs-red-text">|</strong> 
           <a class="no-underline" target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}/mentor">Industry Mentorship</a>
           <br> 
           <a class="no-underline" target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}/job">Jobs in Sports</a>
           <strong class="sbs-red-text">|</strong> 
           <a class="no-underline" target="_blank" rel="noopener" href="{{env('CLUBHOUSE_URL')}}/sales-vault">Sales Training</a></p>
        <p><a class="no-underline" href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}"><strong>Become a Clubhouse PRO Member</strong></a><br>{{CLUBHOUSE_FREE_TRIAL_DAYS}}-day free trial&nbsp;&nbsp;$7/month</p>
        <a href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" style="height:50px;width:60%;padding:20px;line-height: 12px;" class="btn sbs-red">Subscribe Now</a>
    </div>
</div>
@endsection
