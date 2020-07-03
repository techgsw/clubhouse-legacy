@extends('layouts.clubhouse')
@section('title', 'Career Services')
@section('hero')
    <div class="row hero bg-image career-services">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/career-services-white.png" />
            <h4 class="header">Career Services</h4>
            <p>Get some 1 on 1 training and coaching from <a class="" href="{{ env('APP_URL') }}/about">theClubhouse team</a> of sports industry professionals.</p>
            <a href="#Career+Coaching" class="btn btn-large sbs-red">CAREER COACHING</a>
            <!--<a href="#Sales+Training" class="btn btn-large sbs-red">SALES TRAINING</a>-->
            <!--<a href="#Leadership+Development" class="btn btn-large sbs-red">LEADERSHIP DEVELOPMENT</a>-->
        </div>
    </div>
@endsection
@php $pd = new Parsedown(); @endphp
@section('content')
<div class="container">
    @foreach ($categories as $category => $products)
        @if (!empty($products))
            <div class="row">
                <div class="col s12">
                    <a name="{{ urlencode($category) }}">
                        <h4 style="margin-top: 50px;">{{ $category }}</h4>
                    </a>
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
                        @include('product.career-services.components.list-item', ['product' => $product])
                    </div>
                @endforeach
            </div>
        @endif
    @endforeach
</div>
@endsection
