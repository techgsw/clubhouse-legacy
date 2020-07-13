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
    @if(is_null($active_author) && is_null($active_tag) && is_null($active_book))
        @if(count($books) > 0)
            <div class="row training-video-book-container" style="margin-top:-20px">
                @foreach($books as $book)
                    <a href="/sales-vault/training-videos?book={{urlencode($book->name)}}">{{$book->name}}</a>
                @endforeach
            </div>
        @endif
    @else
    <div class="row center-align">
        <a class="btn btn-large sbs-red" href="/sales-vault/training-videos">See all videos</a>
    </div>
    @endif
    @if(is_null($active_book))
        <div class="row center-align">
            <div class="col m6 hide-on-small-and-down" style="margin-top:15px;">
                <select name="authors" onchange="javascript:window.location.replace('/sales-vault/training-videos?author=' + this.value);">
                    <option selected="true" disabled>Search by SBS Coach</option>
                    @foreach ($authors as $author)
                        <option value="{{ urlencode(str_ireplace('Author:', '', $author->name)) }}">{{ str_ireplace('Author:', '', $author->name) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col s12 hide-on-med-and-up" style="margin-top:15px;">
                <div class="center-align"><h5>Authors:</h5></div>
                @foreach ($authors as $author)
                    <a class="flat-button btn-small black" style="display: inline-block; margin: 4px;" href="/sales-vault/training-videos?author={{ urlencode(str_ireplace('Author:', '', $author->name)) }}">{{ str_ireplace('Author:', '', $author->name) }}</a>
                @endforeach
            </div>
            <div class="col s12 m6">
                <form id="find-training-video-by-tag" method="GET" action="/sales-vault/training-videos">
                    <div class="input-field">
                        <input id="find-tag-name" name="tag" type="text" class="tag-autocomplete training-videos" target-view-id="find-training-video-by-tag" autocomplete="off">
                        <label for="find-tag">Search by tag</label>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="tag-cloud center-align" style="margin-bottom: 40px;">
            @foreach($tags_for_book as $tag)
                <a href="/sales-vault/training-videos?tag={{urlencode($tag->slug)}}" class="flat-button black" style="display: inline-block; margin: 4px;">{{$tag->name}}</a>
            @endforeach
        </div>
    @endif
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
    @if(!is_null($active_author) || !is_null($active_tag) || !is_null($active_book))
        @if(count($books) > 0)
            <div class="row training-video-book-container" style="margin-top:-20px">
                @foreach($books as $book)
                    <a href="/sales-vault/training-videos?book={{urlencode($book->name)}}">{{$book->name}}</a>
                @endforeach
            </div>
        @endif
    @endif
    <br><br>
@endsection
