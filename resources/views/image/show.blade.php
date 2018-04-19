<!-- /resources/views/image/show.blade.php -->
@extends('layouts.default')
@section('title', "Image $image->id")
@section('content')
<div class="container">
    <div class="row center">
        <div class="col s12">
            <div class="row">
                <div class="col s4">
                    <img src={{ $image->getURL('medium') }} style="max-height: 200px;">
                </div>
                <div class="col s8">
                    <p>{{ $image->path }}</p>
                </div>
            </div>
        </div>
        @foreach (['small', 'medium', 'large', 'share'] as $size)
            <div class="row">
                <div class="col s4">
                    <img src={{ $image->getURL($size) }} style="max-height: 200px;">
                </div>
                <div class="col s8">
                    <p>{{ $image->getPath($size) }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
