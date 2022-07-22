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
        @if (request('tag'))
            <div style="margin: 12px 0; border-radius: 4px; background: #F2F2F2; padding: 10px 14px;">
                @if (request('tag') && is_null($active_tag))
                    Sorry, we couldn't find any tags named <b>{{request('tag')}}</b>
                    <a href="/training/training-videos" style="float: right;">Go Back</a>
                @else
                    <b>{{ $videos->total() }}</b> result{{ count($videos) > 1 || count($videos) == 0 ? "s" : "" }}
                    @if (request('tag'))
                        tagged <b>{{ $active_tag->name }}</b>
                    @endif
                    <a href="/training/training-videos" style="float: right;">Clear</a>
                @endif
            </div>
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
