@extends('layouts.clubhouse')
@section('title', 'Career Services')
@section('hero')
    <div class="row hero bg-image career-services">
        <div class="col s12">
            <h4 class="header">Career Services</h4>
            <p>Using our industry experience and strong network our goal is to help you get to the next step in your sports business career.</p>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    @foreach ($categories as $category => $products)
        @if (!empty($products))
            <div class="row">
                <div class="col s12">
                    <h4 name="{{ $category }}">{{ $category }}</h4>
                    <div class="card-flex-container">
                        @foreach ($products as $product)
                            @include('product.career-services.components.list-item', ['product' => $product])
                        @endforeach
                        <div class="card-placeholder large"></div>
                        <div class="card-placeholder large"></div>
                        <div class="card-placeholder large"></div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
@endsection
