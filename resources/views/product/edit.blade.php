<!-- /resources/views/product/edit.blade.php -->
@extends('layouts.default')
@section('title', $product->name)
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
            @include('product.forms.tag', ['product' => $product])
            @include('product.forms.edit')
        </div>
    </div>
</div>
@endsection
