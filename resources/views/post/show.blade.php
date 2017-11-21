<!-- /resources/views/post/show.blade.php -->
@extends('layouts.default')
@section('title', $title)
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
            <div class="blog-post">
                <h2 class="title">{{ $title }}</h2>
                {!! $body !!}
            </div>
        </div>
    </div>
</div>
@endsection
