<!-- /resources/views/post/show.blade.php -->
@extends('layouts.default')
@section('title', $post->title)
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h3>{{ $post->title }}</h3>
            <div>
                {{ $post->body }}
            </div>
        </div>
    </div>
</div>
@endsection
