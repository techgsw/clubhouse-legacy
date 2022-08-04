@php $pd = new Parsedown(); @endphp
@extends('layouts.clubhouse')
@section('title', 'Webinars')
@php
    if (request('search')) {
        $url = "/webinars?search=" . request('search') . "&";
    } else {
        $url = "/webinars?";
    }
@endphp

@section('content')
    <div class="container">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
        @if(is_null($active_tag))
            <div class="row" style="margin-bottom: unset;">
                <div class="col s12">
                    <h4 id="upcoming" style="font-weight: bold; text-align: center;">UPCOMING WEBINAR EVENTS</h4>
                </div>
            </div>
            <div class="row">
                @if (count($active_products) < 1)
                    <h5 style="text-align: center;">Coming soon.</h5>
                @else
                    @foreach ($active_products as $product)
                        <div class="col l6" style="display: flex; justify-content: center;">
                            @include('product.webinars.components.list-item', ['product' => $product])
                        </div>
                    @endforeach
                @endif
            </div>
            <hr class="sbs-red" style="color: #EB2935;"/>
        @endif
        @if (count($inactive_products) > 0)
            <div class="row">
                <div class="col s12">
                    <h4 id="past" style="font-weight: bold; text-align: center;">PAST WEBINAR EVENTS</h4>
                </div>
                <div class="col s12 center-align" style="margin-top:20px;">
                    <strong><span class="sbs-red-text">FREE Sign up</span>: Watch with a free membership</strong>
                    <br>
                    <strong><span class="sbs-red-text">PRO Member</span>: Watch with a Clubhouse PRO membership</strong>
                    <br>
                    <strong><span class="sbs-red-text">WATCH NOW</span>: No signup required</strong>
                </div>
            </div>
            <div class="row">
                @include('components.page-search', ['base_url' => '/webinars'])
            </div>
            @if (request('search') || request('tag'))
                @include('components.page-search-found', ['base_url' => '/webinars', 'items' => $inactive_products, 'not_found' => $active_tag])
            @endif
            <div class="row">
                @foreach ($inactive_products->chunk(6) as $chunked_products)
                    <div class="row" style="max-height: 0;">
                        @foreach($chunked_products as $product)
                            <div class="col s12 m6 l4">
                                @include('product.webinars.components.inactive-card-item', ['$product' => $product])
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col s12 center-align">
                    {{ $inactive_products->appends(request()->all())->fragment('past')->links('components.pagination') }}
                </div>
            </div>
        @elseif (!is_null($active_tag))
            <div class="row">
                <div class="col s12">
                    <h4 id="past" style="font-weight: bold; text-align: center;">No past webinar events matching
                        <strong>{{ $active_tag->name }}</strong></h4>
                </div>
            </div>
        @endif
    </div>
@endsection
