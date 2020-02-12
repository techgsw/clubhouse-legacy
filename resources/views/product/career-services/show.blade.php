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
        <div class="col s12 m3">
            @if (!is_null($product->primaryImage()))
                <img style="padding: 18px 24px;" src={{ $product->primaryImage()->getURL('medium') }}>
            @endif
        </div>
        <div class="col s12 m9 product-description">
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
                            @can ('view-clubhouse')
                                <option value="{{$option->id}}">{{$option->name}}: {{ $option->description }} - ${{number_format(round($option->price / 2), 2)}} (FREE with Clubhouse Pro)</option>
                            @else
                                <option value="{{$option->id}}">{{$option->name}}: {{ $option->description }} - ${{number_format($option->price, 2)}}</option>
                            @endcan
                        @else
                            <option value="{{$option->id}}">{{$option->name}}</option>
                        @endif
                    @endforeach
                </select>
                @can ('view-clubhouse')
                    <div class="input-field" style="margin-top: 30px;">
                        <a href="{{ $product->options[0]->getURL(false, 'checkout') }}" id="buy-now" class="btn sbs-red">SIGN UP</a>
                    </div>
                @else
                    <p>Want to get <strong>FREE</strong> Career Services? <a href="/membership-options">Click here to become a <strong>Clubhouse Pro</strong></a></p>
                    <div class="input-field" style="margin-top: 30px;">
                        <a href="{{ $product->options[0]->getURL(false, 'checkout') }}" id="buy-now" class="btn sbs-red">CHECKOUT</a>
                    </div>
                @endcannot
            @else
                @can ('view-clubhouse')
                    <p>This career service is currently unavailable.</p>
                @else
                    <p>There are only <strong>Clubhouse Pro</strong> options available at this time.</p>
                    <div class="input-field" style="margin-top: 30px;">
                        <a href="/pricing" id="buy-now" class="btn sbs-red">Become a Clubhouse Pro</a>
                    </div>
                @endcan
            @endif
        </div>
    </div>
</div>
@endsection
