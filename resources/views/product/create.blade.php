<!-- /resources/views/product/create.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'New Product')
@section('scripts')
    @include('product.components.scripts')
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    @include('product.components.instructions', ['training_video_book_chapter_map' => $training_video_book_chapter_map])
    <div class="row">
        <div class="col s12">
            @include('product.forms.tag', ['product' => null])
            @include('product.forms.create')
        </div>
    </div>
</div>
@endsection
