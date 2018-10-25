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
            <h5>Reserved for our <strong><a class="no-underline" href="/pricing">Clubhouse Pro</a></strong> memebers, these live virtual webinars are a chance for you to interact with some of the most respected sports industry professionals in the business.</h5>
            <p>The guest speakers and members of the Clubhouse leadership team will have a conversation about topics in sports business, and you can follow along from the comfort of your phone or home computer!  You can email in questions and we’ll ask them on air in real time. After, you will be emailed a recording of the show to keep on file for future reference.</p>
            <p>This is the most affordable way to meet, and learn from, some of the very best in the sports business industry. Hope to see you there!</p>
            <h4 style="font-weight: bold; text-align: center;">UPCOMING WEBINAR EVENTS</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card-flex-container webinars">
                @foreach ($products as $product)
                    @include('product.webinars.components.list-item', ['product' => $product])
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
