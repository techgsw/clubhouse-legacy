@extends('layouts.clubhouse')
@section('title', $book.' - Training Videos')
@section('hero')
    <div class="row center-align">
        <div class="col s12" style="margin-top:20px;">
            <h3>{{$book}}</h3>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    @if(count($training_videos_by_chapter) < 1)
        <div class="row center-align">
            <h5>Videos for <strong>{{$book}}</strong> coming soon.</h5>
        </div>
    @else
        @foreach ($training_videos_by_chapter as $chapter => $videos)
            <div class="col s12">
                <ul class="collapsible">
                    <li>
                        <div class="collapsible-header">{{$chapter}}<span style="float: right;">+</span></div>
                        <div class="collapsible-body row">
                            @foreach($videos as $video)
                                @include('product.training-videos.components.list-item', ['video' => $video])
                            @endforeach
                            @if (count($videos) > 4)
                                <div class="col s12 center-align" style="margin-top:20px;">
                                    <a href="/sales-vault/training-videos?book={{urlencode($book)}}&chapter={{urlencode($chapter)}}" class="btn btn-large sbs-red">See More Videos</a>
                                </div>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
        @endforeach
    @endif
    <br><br>
    <div class="row training-video-book-container">
        @foreach($books as $book)
            <a href="/sales-vault/training-videos?book={{urlencode($book->name)}}">{{$book->name}}</a>
        @endforeach
    </div>
@endsection
