@extends('layouts.clubhouse')
@section('title', $chapter.' - Training Videos')
@section('hero')
    <div class="row center-align">
        <div class="col s12" style="margin-top:20px;">
            <h3>{{$chapter}}</h3>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    @if(count($training_videos) < 1)
        <div class="row center-align">
            <h5>Videos for <strong>{{$chapter}}</strong> coming soon.</h5>
        </div>
    @else
        <div class="row">
            @foreach($training_videos as $video)
                @include('product.training-videos.components.list-item', ['video' => $video])
            @endforeach
            <div class="row">
                <div class="col s12 center-align">
                    {{ $training_videos->appends(request()->all())->fragment('past')->links('components.pagination') }}
                </div>
            </div>
        </div>
    @endif
        <div class="col s12 center-align" style="margin-top:20px;">
            <a href="/training-videos?book={{urlencode($book)}}" class="btn btn-large sbs-red">View more from {{$book}}</a>
        </div>
        <br><br>
@endsection
