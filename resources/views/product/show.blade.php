<!-- /resources/views/product/show.blade.php -->
@extends('layouts.default')
@section('title', "$product->name")
@section('description', "$product->description")
@section('url', Request::fullUrl())
@if (!is_null($product->primaryImage()))
    @section('image', $product->primaryImage()->cdn ? $product->primaryImage()->getURL('share') : url('/').$product->primaryImage()->getURL('share'))
@endif
@section('scripts')
    @include('product.components.scripts')
@endsection
@php $pd = new Parsedown(); @endphp
@section('content')
<div class="container" style="padding-bottom: 40px;">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    <!-- Product -->
    <div class="row product-show">
        <div class="col s12 m5">
            @if (!is_null($product->primaryImage()))
                <img src={{ $product->primaryImage()->getURL('medium') }}>
            @endif
        </div>
        <div class="col s12 m7 product-description">
            <div class="right">
                <!-- Job controls -->
                <p class="small">
                @can ('edit-product', $product)
                    <a href="/product/{{ $product->id }}/edit" class="flat-button small blue"><i class="fa fa-pencil"></i> Edit</a>
                @endcan
                </p>
            </div>
            <h4>{{ $product->name }}</h4>
            {!! $pd->text($product->description) !!}
            <select class="browser-default product-option-select" name="option">
                @foreach ($product->options as $option)
                    <option value="{{$option->id}}">{{$option->name}} — ${{number_format($option->price, 2)}}</option>
                @endforeach
            </select>
            <div class="options">
                @php $first = true; @endphp
                @foreach ($product->options as $option)
                    <div class="product-option-description {{ $first ? "" : "hidden"}}" option-id="{{$option->id}}">
                        {!! $pd->text($option->description) !!}
                    </div>
                    @php $first = false; @endphp
                @endforeach
            </div>
            <div class="input-field" style="margin-top: 30px;">
                <button id="buy-now" type="button" class="btn sbs-red">BUY NOW</button>
            </div>
        </div>
    </div>
</div>
@endsection
