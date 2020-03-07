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
    <divm class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </divm>
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
                @if ($tag->name != 'Webinar')
                    <a href="/same-here/webinars?tag={{ urlencode($tag->slug) }}" class="small flat-button black" style="display: inline-block; margin-left:4px">{{ $tag->name }}</a>
                @endif
            @endforeach
            {!! $pd->text($product->getCleanDescription()) !!}
            @if ($product->active)
                @if (count($product->options) > 0)
                    @foreach ($product->options as $option)
                            <p>{{$option->name}} {{preg_split("/join_url:/", $option->description)[0]}}&nbsp;&nbsp;<a href="{{preg_split("/join_url:/", $option->description)[1]}}" class="btn red">JOIN</a></p>
                    @endforeach
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
