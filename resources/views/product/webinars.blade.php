@extends('layouts.clubhouse')
@section('title', 'Webinars')
@section('hero')
    <div class="row hero bg-image career-services">
        <div class="col s12">
            <h4 class="header">Webinars</h4>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <p>Bob & the team at Sports Business Solutions host FREE regularly scheduled webinar video sessions. They’re perfect for seasoned industry professionals and those looking to enter the sports industry!</p>
            <p>These sessions are LIVE and run for 30-45 minutes, covering a variety of topics related to sports business. Topics will include: sports sales, marketing, sponsorship, analytics, leadership development and more for current and aspiring sports industry pros. They’ll also cover sports job search, resume & interview tips, educational sessions on sports business basics and FAQ sessions for sports business job seekers.</p>
            <p>Some sessions are private, and some are open, but one thing is for sure, we have something for everyone!</p>
            <p style="font-weight: bold; text-align: center;">Please find our upcoming webinar schedule below</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card-flex-container">
                @foreach ($products as $product)
                    @include('product.webinars.components.list-item', ['product' => $product])
                @endforeach
                <div class="card-placeholder"></div>
                <div class="card-placeholder"></div>
                <div class="card-placeholder"></div>
            </div>
        </div>
    </div>
</div>
@endsection
