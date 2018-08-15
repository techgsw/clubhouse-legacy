@extends('layouts.clubhouse')
@section('title', 'Career Services')
@section('hero')
    <div class="row hero bg-image career-services">
        <div class="col s12">
            <h4 class="header">Career Services</h4>
            <p>Using our industry experience and strong network our goal is to help you get to the next step in your sports business career.</p>
            <a href="#top" class="btn btn-large sbs-red">Let's get started</a>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card-flex-container">
                @foreach ($products as $product)
                    @include('product.components.list-item', ['product' => $product])
                @endforeach
                <div class="card-placeholder large"></div>
                <div class="card-placeholder large"></div>
                <div class="card-placeholder large"></div>
            </div>
        </div>
    </div>
</div>
@endsection
