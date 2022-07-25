@extends('layouts.clubhouse')
@section('title', 'Training Videos')
@section('hero')
    <div class="row center-align">
        <div class="col s12" style="margin-top:20px;margin-bottom: -20px;">
            <h3>Training Videos</h3>
        </div>
    </div>
@endsection
@php
    if (request('search')) {
        $url = "/training/training-videos?search=" . request('search') . "&";
    } else {
        $url = "/training/training-videos?";
    }
@endphp
@section('content')
<div class="container">
    @if(count($videos) < 1)
        <div class="row center-align">
            <h5>Training Videos coming soon.</h5>
        </div>
    @else
            <div class="row">
                @include('components.page-search', ['base_url' => '/training/training-videos'])
            </div>
            @if (request('search') || request('tag'))
                @include('components.page-search-found', ['base_url' => '/training/training-videos', 'items' => $videos, 'not_found' => $active_tag])
            @endif

        <div class="row">
            @foreach($videos->chunk(6) as $chunked_videos)
                <div class="row" style="max-height: 0;">
                    @foreach($chunked_videos as $video)
                        <div class="col s12 m6 l4" >
                            @include('product.training-videos.components.list-item', ['video' => $video])
                        </div>
                    @endforeach
                </div>
            @endforeach
        <div class="row">
            <div class="col s12 center-align">
                {{ $videos->appends(request()->all())->fragment('past')->links('components.pagination') }}
            </div>
        </div>
    </div>
    @endif
    <br><br>
@endsection
