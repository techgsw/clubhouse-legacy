<!-- /resources/views/product/show.blade.php -->
@extends('layouts.clubhouse')
@section('title', "$product->name")
@section('description', $product->getCleanDescription())
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
            @if (!is_null($product->primaryImage()) && $product->active)
                <div class="card">
                    <div class="card-image">
                        <img style="responsive-img" src={{ $product->primaryImage()->getURL('large') }}>
                    </div>
                </div>
            @else
                @can ('view-clubhouse')
                    <div class="video-container">
                        <iframe width="640" height="564" src="https://player.vimeo.com/video/{{ $product->getEmbedCode() }}" frameborder="0" allowFullScreen mozallowfullscreen webkitAllowFullScreen></iframe>
                    </div>
                @else
                    <div class="card">
                        <div class="card-image">
                            <img style="responsive-img" src={{ $product->primaryImage()->getURL('large') }}>
                            <div style="background-color: rgba(0, 0, 0, .7); position: absolute; top: 0; left: 0; width: 100%; height: 100%;">
                                <div class="col s12 center-align" style="margin-top: 10%">
                                    <h4 style="color: #FFF">Want to watch this webinar?</h4>
                                    <a href="/membership-options" id="buy-now" class="btn sbs-red">Become a Clubhouse Pro</a>
                                </div>
                            </div> 
                        </div>
                    </div>
                @endcan
            @endif

        </div>
        <div class="col s12 m5 product-description">
            @can ('edit-product', $product)
                <div class="right">
                    <!-- Job controls -->
                    <p class="small">
                        <a href="/product/{{ $product->id }}/edit" class="flat-button small blue"><i class="fa fa-pencil"></i> Edit</a>
                    </p>
                </div>
            @endcan
            <h4>{{ $product->name }}</h4>
            {!! $pd->text($product->getCleanDescription()) !!}
            @if ($product->active)
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
                    @can ('view-clubhouse')
                        <div class="input-field" style="margin-top: 30px;">
                            <a href="{{ $product->options[0]->getURL(false, 'checkout') }}" id="buy-now" class="btn green">RSVP NOW</a>
                        </div>
                    @else
                        <div class="input-field" style="margin-top: 30px;">
                            <h5 style="">Want to RSVP?</h5>
                            <a href="/membership-options" id="buy-now" class="btn sbs-red">Become a Clubhouse Pro</a>
                        </div>
                    @endcan
                @else
                    @can ('view-clubhouse')
                        <p>This webinar is currently unavailbable.</p>
                    @else
                        <div class="input-field" style="margin-top: 30px;">
                            <h5 style="">Want to RSVP?</h5>
                            <a href="/membership-options" id="buy-now" class="btn sbs-red">Become a Clubhouse Pro</a>
                        </div>
                        <p><strong>*Only Clubhouse Pro options available at this time.</strong></p>
                    @endcan
                @endif
            @else
                <a href="/webinars" class="btn blue">Browse all webinars</a>
            @endif
        </div>
    </div>
</div>
@endsection
