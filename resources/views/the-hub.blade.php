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
                <h4 class="header">Join our community</h4>
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
        <div class="row">
            <div class="col s12">
                <h4>Blog</h4>
            </div>
        </div>
    @endif
</div>
@endsection
