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
        <div class="col s12 m5">
            @if (!is_null($product->primaryImage()))
                <img style="padding: 18px 24px;" src={{ $product->primaryImage()->getURL('medium') }}>
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
            {!! strip_tags($pd->text($product->description)) !!}
        </div>
    </div>
    @can ('edit-product', $product)
        @if (count($transactions) > 0)
            <table class="striped">
                <thead>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Purchase Date</th>
                    <th>Paid</th>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->first_name .  ' ' . $transaction->last_name }}</td>
                            <td><a class="no-underline" href="mailto:{{ $transaction->email }}">{{ $transaction->email }}</a></td>
                            <td>{{ $transaction->order_date }}</td>
                            <td>${{ $transaction->price }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endcan
    @include('layouts.components.messages')
    <div class="row">
        <div class="col s12">
        </div>
    </div>
</div>
@endsection
