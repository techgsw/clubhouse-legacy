@extends('layouts.clubhouse')
@section('title', 'Training Videos')
@section('hero')
    <div class="row center-align">
        <div class="col s12" style="margin-top:20px;margin-bottom: -20px;">
            <h3>Sales Training Videos</h3>
            @if(!is_null($active_tag))
                <h5>{{$active_tag->name}}</h5>
            @elseif(!is_null($active_author))
                <h5>Matching SBS Coach {{str_ireplace('Author:', '', $active_author->name)}}</h5>
            @elseif(!is_null($active_book))
                <h5><strong>{{$active_book}}</strong></h5>
            @endif
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    @if(!is_null($active_author) || !is_null($active_tag) || !is_null($active_book))
        <div class="row center-align">
            <a class="btn btn-large sbs-red" href="/sales-vault/training-videos">See all videos</a>
        </div>
    @endif
    <div class="tag-cloud center-align" style="margin-bottom: 40px;">
        @foreach($tags as $tag)
            <a href="/sales-vault/training-videos?tag={{urlencode($tag->slug)}}" class="flat-button black" style="display: inline-block; margin: 4px;">{{$tag->name}}</a>
        @endforeach
    </div>
    @if(count($videos) < 1)
        <div class="row center-align">
            <h5>Training Videos coming soon.</h5>
        </div>
    @else
        <div class="row">
            @foreach($videos as $video)
                @include('product.training-videos.components.list-item', ['video' => $video])
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
