@extends('layouts.clubhouse')
@section('title', 'Training Videos')
@section('hero')
    <div class="row center-align">
        <div class="col s12" style="margin-top:20px;">
            <h3>Training Videos</h3>
            @if(!is_null($active_tag))
                <h5>Matching tag {{$active_tag->name}}</h5>
            @elseif(!is_null($active_author))
                <h5>Matching author {{str_ireplace('Author:', '', $active_author->name)}}</h5>
            @endif
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    @if(count($books) > 0)
        <div class="row training-video-book-container">
            @foreach($books as $book)
                <a href="/sales-vault/training-videos?book={{urlencode($book->name)}}">{{$book->name}}</a>
            @endforeach
        </div>
    @endif
    @if(count($authors) > 0)
        <div class="row center-align">
            <h5>Authors</h5>
            <div class="tag-cloud center-align">
                @foreach ($authors as $author)
                    <a href="/sales-vault/training-videos?author={{ urlencode(str_ireplace('Author:', '', $author->name)) }}" class="flat-button black" style="display: inline-block; margin: 4px;">{{ str_ireplace('Author:', '', $author->name) }}</a>
                @endforeach
            </div>
        </div>
    @endif
        <div class="row center-align">
            <form id="find-book-chapter" method="GET" action="/sales-vault/training-videos">
                <div class="input-field col s12 m4 offset-m4">
                    <input id="find-book-name" type="hidden" name="book">
                    <input id="find-chapter-name" name="chapter" type="text" class="find-book-chapter-autocomplete" autocomplete="off">
                    <label for="find-chapter-name">Find a section</label>
                </div>
            </form>
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
