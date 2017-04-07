@extends('layouts.default')
@section('title', 'The Hub')
@section('subnav')
    @include('layouts.subnav.sales-center')
@endsection
@section('hero')
    <div class="row hero bg-image">
        <div class="col s12">
            <h4 class="header">The Hub</h4>
            <p>A career development platform for current and aspiring sports sales professionals.</p>
        </div>
        <div class="col s12" style="margin-top: 30px;">
            <a id="hub-video" href="#hub-video-modal"><i class="fa fa-play-circle-o fa-4x" aria-hidden="true"></i></a>
            <div id="hub-video-modal" class="modal">
                <div class="modal-content">
                    {!! $video !!}
                </div>
            </div>
        </div>
    </div>
    @if (!Auth::check())
        <div class="row hero gray">
            <div class="col s12">
                <h4>Join our community</h4>
            </div>
        </div>
        <div class="row">
            <div class="col s12 center-align">
                <div class="arrow down"></div>
            </div>
        </div>
    @endif
@endsection
@section('content')
<div class="container">
    @if (!Auth::check())
        <div class="row">
            <div class="col s12">
                @include('layouts.components.errors')
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                @include('forms.register')
            </div>
        </div>
    @endif
    @if (Auth::check())
        @if (count($posts) > 0)
            <div class="row">
                <div class="col s12">
                    <h4 class="header center-align">Latest Blog Posts</h4>
                </div>
            </div>
            <div class="row blog">
                @foreach ($posts as $key => $post)
                    <a class="blog-post-link" href="{{ $post->link }}">
                        <div class="col s12 {{ $key > 0 ? "m6" : ""}} blog-post-container">
                            <div class="blog-post-wrapper" style="background-image: url({{ $post->image_url }});">
                                <div class="blog-post">
                                    <h5 style="margin: auto">{{ $post->title->rendered }}</h5>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    @endif
</div>
@endsection
