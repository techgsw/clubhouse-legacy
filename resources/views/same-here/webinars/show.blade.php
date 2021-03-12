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
                    <div class="video-container">
                        <iframe width="640" height="564" src="https://player.vimeo.com/video/{{ $product->getEmbedCode() }}" frameborder="0" allowFullScreen mozallowfullscreen webkitAllowFullScreen></iframe>
                    </div>
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
                @foreach($product->tags as $tag)
                    @if ($tag->name != '#SameHere' && $tag->name != 'Webinar')
                        <a href="/same-here/webinars?tag={{ urlencode($tag->slug) }}" class="small flat-button black" style="display: inline-block; margin-left:4px">{{ $tag->name }}</a>
                    @endif
                @endforeach
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
                        @if (Auth::user())
                            <div class="input-field" style="margin-top: 30px;">
                                <a href="{{$product->options[0]->getURL(false, 'checkout')}}" data-price="{{$product->options[0]->price}}" id="buy-now" class="btn green">RSVP NOW</a>
                            </div>
                        @else
                            <div class="input-field" style="margin-top: 30px;">
                                <a href="#register-modal" id="buy-now" class="btn sbs-red">REGISTER TO RSVP</a>
                            </div>
                        @endif
                    @else
                        <p>This webinar is currently unavailbable.</p>
                    @endif
                @else
                    <a href="/same-here/webinars" class="btn blue">Browse all #SameHere discussions</a>
                @endif
            </div>
        </div>
    </div>
@endsection
