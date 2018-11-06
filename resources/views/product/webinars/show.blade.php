<!-- /resources/views/product/show.blade.php -->
@extends('layouts.clubhouse')
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
        <div class="col s12 m7">
            @if (!is_null($product->primaryImage()))
                <div class="card">
                    <div class="card-image">
                        <img style="responsive-img" src={{ $product->primaryImage()->getURL('large') }}>
                    </div>
                </div>
            @endif
        </div>
        <div class="col s12 m5 product-description">
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
            @if (count($product->options) > 0)
                <select class="browser-default product-option-select" name="option">
                    @foreach ($product->options as $option)
                        @if ($option->price > 0)
                            <option value="{{$option->id}}" data-link="{{ $option->getURL(false, 'checkout') }}">{{$option->name}} — ${{number_format($option->price, 2)}}</option>
                        @else
                            <option value="{{$option->id}}" data-link="{{ $option->getURL(false, 'checkout') }}">{{$option->name}} {{ $option->description }}</option>
                        @endif
                    @endforeach
                </select>
            @endif
            @if (count($product->options) > 0)
                <div class="input-field" style="margin-top: 30px;">
                    <a href="{{ $product->options[0]->getURL(false, 'checkout') }}" id="buy-now" class="btn sbs-red">CHECKOUT</a>
                </div>
            @else
                @can ('view-clubhouse')
                    <p>This webinar is currently unavailbable.</p>
                @else
                    <div class="input-field" style="margin-top: 30px;">
                        <a href="/membership-options" id="buy-now" class="btn sbs-red">Become a Clubhouse Pro</a>
                    </div>
                    <p><strong>*Only Clubhouse Pro options available at this time.</strong></p>
                @endcan
            @endif
        </div>
    </div>
</div>
@endsection
