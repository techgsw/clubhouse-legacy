@php $pd = new Parsedown(); @endphp
@extends('layouts.clubhouse')
@section('title', 'Webinars')
@section('hero')
    <div class="row hero bg-image webinars">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/event-white.png" />
            <h4 class="header">Educational Webinars</h4>
            <p>Join these live events and listen in as industry professionals discuss the topics of the day and share advice on achieving success in sports.</p>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <p>Reserved for our <strong><a class="no-underline" href="/membership-options">Clubhouse Pro</a></strong> members, these virtual events are a chance for you to interact with some of the most respected sports industry professionals in the business.</p>
            <p>The guest speakers and members of the Clubhouse leadership team will have a conversation about topics in sports business, and you can follow along from the comfort of your phone or home computer!  You can message in questions and we’ll ask them on air in real time. After, you will be emailed a recording of the show to keep on file for future reference.</p>
            <p>This is the most affordable way to meet, and learn from, some of the very best in the sports business industry. Hope to see you there!</p>
            <br />
            <h4 style="font-weight: bold; text-align: center;">UPCOMING WEBINAR EVENTS</h4>
        </div>
    </div>
    <div class="row">
        @foreach ($active_products as $product)
            <div class="col l6">
                @include('product.webinars.components.list-item', ['product' => $product])
            </div>
        @endforeach
    </div>
    @if (count($inactive_products) > 10)
        <div class="row">
            <div class="col s12">
                <h4 style="font-weight: bold; text-align: center;">PAST WEBINAR EVENTS</h4>
            </div>
        </div>
        <div class="row">
            @foreach ($inactive_products as $product)
                <div class="col s12">
                    <ul class="browser-default">
                        <li><span style="font-size: 18px;"><strong>{{ $product->name }}</strong></span><span> {!! $pd->text($product->description) !!}</span></li>
                    </ul>
                    
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
