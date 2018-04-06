<!-- /resources/views/image/show.blade.php -->
@extends('layouts.default')
@section('title', "Image $image->id")
@section('content')
<div class="row center">
    <div class="col s12">
        <div class="row">
            <div class="col s4">
                <img src={{ Storage::disk('local')->url($image->path) }} style="max-height: 200px;">
            </div>
            <div class="col s8">
                <p>{{ $image->path }}</p>
            </div>
        </div>
    </div>
    @foreach (['full', 'main', 'original', 'small', 'medium', 'large'] as $size)
        <div class="row">
            <div class="col s4">
                <img src={{ Storage::disk('local')->url($image->getPath($size)) }} style="max-height: 200px;">
            </div>
            <div class="col s8">
                <p>{{ $image->getPath($size) }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection
