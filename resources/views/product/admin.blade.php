<!-- /resources/views/product/admin.blade.php -->
@extends('layouts.admin')
@section('title', 'Products')
@section('content')
<div id="row">
    <div class="col s12">
        @include('product.forms.admin-search')
    </div>
</div>
<div class="row">
    <div class="col s12">
        @if (count($products) > 0)
            <div class="card-flex-container">
                @foreach ($products as $product)
                    @include('product.components.list-item', ['product' => $product])
                @endforeach
                <div class="card-placeholder large"></div>
                <div class="card-placeholder large"></div>
                <div class="card-placeholder large"></div>
            </div>
            <div class="row">
                <div class="col s12 center-align">
                    {{ $products->appends(request()->all())->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
