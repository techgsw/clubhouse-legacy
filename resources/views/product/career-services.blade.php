@extends('layouts.clubhouse')
@section('title', 'Career Services')
@section('hero')
    <div class="row hero bg-image career-services">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/career-services-white.png" />
            <h4 class="header">Career Services</h4>
            <p><a href="{{ env('APP_URL') }}/about"><span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup> team</a> gives you 1-on-1 coaching that helps elevate your career.</p>
        </div>
    </div>
@endsection
@php $pd = new Parsedown(); @endphp
@section('content')
<div class="container">
    <div class="col s12">
        @include('layouts.components.messages')
        @include('layouts.components.errors')
    </div>
    <!--TODO: add back in when group career services are supported-->
    <!--<p class="center-align sbs-red-text">Note: Clubhouse Pro members can book one free career service every month.</p>-->
    @foreach ($categories as $category => $products)
        @if (!empty($products))
            <div class="row" style="margin-top:20px;">
                <div class="col s12">
                    <div class="card-flex-container">
                        @foreach ($products as $product)
                            @include('product.career-services.components.item-cards', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row career-service-slider">
                @foreach ($products as $product)
                    <div class="career-service-slide" id="service-{{$product->id}}">
                        @include('product.career-services.components.list-item', ['product' => $product, 'is_blocked' => $is_blocked])
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
</div>
@endsection
