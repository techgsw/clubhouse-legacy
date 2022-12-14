@extends('layouts.clubhouse')
@section('title', "$video->name")
@section('description', $video->getCleanDescription())
@section('url', Request::fullUrl())
@php $pd = new Parsedown(); @endphp
@section('content')
<div class="container" style="padding-bottom: 40px;">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    <!-- Product -->
    <div class="row product-show">
        <div class="col s12 m7">
            @if (count($video->availableOptionsForUser()) > 0)
                <div class="video-container">
                    <iframe width="640" height="564" src="https://player.vimeo.com/video/{{ $video->getEmbedCode() }}" frameborder="0" allowFullScreen mozallowfullscreen webkitAllowFullScreen></iframe>
                </div>
            @else
                <div class="card">
                    <div class="card-image">
                        @if (!is_null($video->primaryImage()))
                            <img style="responsive-img" src={{ $video->primaryImage()->getURL('large') }}>
                            <div style="background-color: rgba(0, 0, 0, .7); position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                <div class="col s12 center-align" style="margin-top: 10%">
                                    <h4 style="color: #FFF">Want to watch this video?</h4>
                                    @if ($video->highest_option_role == 'clubhouse')
                                        <a href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" id="buy-now" class="btn sbs-red">Become a Clubhouse Pro</a>
                                    @else
                                        <a href="#register-modal" id="buy-now" class="btn sbs-red">Register for a free account</a>
                                    @endif
                                    @if (!Auth::user())
                                        <p style="color: #FFF">Already a member? <a href="/login">Login</a></p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="row" style="height:275px;">
                                <div class="col s12 center-align" style="margin-top: 10%">
                                    <h4>Want to watch this video?</h4>
                                    @if ($video->highest_option_role == 'clubhouse')
                                        <a href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" id="buy-now" class="btn sbs-red">Become a Clubhouse Pro</a>
                                    @else
                                        <a href="#register-modal" id="buy-now" class="btn sbs-red">Register for a free account</a>
                                    @endif
                                    @if (!Auth::user())
                                        <p>Already a member? <a href="/login">Login</a></p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="col s12 m5 product-description">
            @can ('edit-product', $video)
                <div class="right">
                    <!-- Job controls -->
                    <p class="small">
                        <a href="/product/{{ $video->id }}/edit" class="flat-button small blue"><i class="fa fa-pencil"></i> Edit</a>
                    </p>
                </div>
            @endcan
            <h4>{{ $video->name }}</h4>
            @if(!is_null($video->getTrainingVideoAuthor()))
                <span>by {{$video->getTrainingVideoAuthor()}}</span>
                <br>
                <span>in {{$video->options->first()->name}}</span>
            @endif
            @foreach($video->tags as $tag)
                @if ($tag->name != 'Training Video' && stripos($tag->name, 'Author:') === false)
                    <a href="/training/training-videos?tag={{ urlencode($tag->slug) }}" class="small flat-button black" style="display: inline-block; margin-left:4px">{{ $tag->name }}</a>
                @endif
            @endforeach
            {!! $pd->text($video->getCleanDescription()) !!}
            <br>
            <a style="height:auto;line-height:20px;padding-top:8px;padding-bottom:8px;margin-bottom:10px;" href="/training/training-videos" class="btn sbs-red">Browse all videos</a>
        </div>
    </div>
</div>
@endsection
