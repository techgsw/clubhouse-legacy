<!-- /resources/views/product/create.blade.php -->
@extends('layouts.default')
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
    <div class="row">
        <div class="col s12">
            @include('product.forms.create')
        </div>
    </div>
</div>
@endsection
