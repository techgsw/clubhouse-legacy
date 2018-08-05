@extends('layouts.clubhouse')
@section('title', 'Careers in Sports')
@section('hero')
    <div class="row hero bg-image clubhouse">
        <div class="container">
            <div class="row">
                <div class="col m6">
                    <h4 class="header" style="margin-top: 0;">Welcome to the Clubhouse!</h4>
                    <p>The Clubhouse is a destination for current and aspiring sports business professionals who are committed to achieving success in sports. People in this community have a desire to learn, share industry best practices, and network with each other in an effort to grow individually and elevate the sports industry as a whole.</p>
                    <p>Whether you want to meet industry pros, you want to give back and help others, or you want a job, we’re confident this platform is your ticket to sports industry success.</p>
                </div>
                <div class="col m6">
                    <div class="fill-grey hide-on-small-only" style="position: absolute;">
                        <img src="/images/clubhouse/medal.png" style="float: right; margin-top: 20px; margin-right: 20px;" />
                        <p class="header font-black" style="font-size: 24px; margin-top: 40px; margin-left: 20px;"><strong>Ready to join?</strong></p>
                        <ul class="browser-default">
                            <li>Talk to sports industry mentors</li>
                            <li>Learn industry best practices</li>
                            <li>Join us for private events and webinars</li>
                            <li>Gain a competitive edge when job seeking</li>
                            <li>Apply for new jobs in sports</li>
                            <li>Flexible membership options available</li>
                        </ul>
                        <div style="padding-left: 20px; padding-right: 20px;">
                            @include('components.register-clubhouse')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row show-on-small hidden">
            <div class="col s12">
                <img src="/images/clubhouse/medal.png" style="float: right; margin-top: 20px;" />
                <p class="header font-black" style="font-size: 24px; margin-top: 40px; margin-left: 20px;"><strong>Ready to join?</strong></p>
                <ul class="browser-default">
                    <li>Talk to sports industry mentors</li>
                    <li>Learn industry best practices</li>
                    <li>Join us for private events and webinars</li>
                    <li>Gain a competitive edge when job seeking</li>
                    <li>Apply for new jobs in sports</li>
                    <li>Flexible membership options available</li>
                </ul>
                @include('components.register-clubhouse')
            </div>
        </div>
        <div class="row">
            <div id="clubhouse-title-text" class="col s12 center-align">
                <h2>Where the sports industry goes to <strong><u>learn</u></strong>.<h2>
                <hr class="sbs-red" style="color: #EB2935;" />
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 center-align">
                <img class="" style="width: 100px; margin-top: 50px;" src="/images/clubhouse/digital-marketing.png" />
                <h3>Sports industry blog</h3>
            </div>
        </div>
        <div class="row">
            @if (count($posts) > 0)
                @foreach ($posts as $post)
                    <div class="col s4">
                        <div class="col s12 about-cards">
                            <a href="/post/{{ $post->title_url}}" class="no-underline"><img class="img-responsive" src="{{ $post->images->first()->getURL('medium') }}" /></a>
                        </div>
                        <div class="col s12">
                            <h5 style="margin-top: 0; margin-bottom: 10px; display: block;"><a href="/post/{{ $post->title_url }}" class="no-underline">{{ $post->title }}</a></h5>
                            <a href="/post/{{ $post->title_url }}" class="sbs-red-text no-underline">READ MORE ></a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row">
            <div class="col s12 center-align">
                <a href="/blog" class="btn sbs-red" style="margin-top: 20px;"> More articles</a>
            </div>
        </div>
    </div>
    <div class="fill-grey">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <img class="" style="width: 100px; margin-top: 50px;" src="/images/clubhouse/mentorship.png" />
                    <h3>Mentorship</h3>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="carousel carousel-slider center" data-indicators="true">
                        @if (count($mentors) > 0)
                            @foreach ($mentors as $index => $mentor)
                                @if ($index == 0 || $index % 2) 
                                    <div class="carousel-item" href="#">
                                        <div class="row">
                                @endif
                                <div class="col s6">
                                    <div class="col m4">
                                        @if ($mentor->contact->headshotImage)
                                            <img src="{{ $mentor->contact->headshotImage->getURL('medium') }}" class="responsive-img circle"/>
                                        @elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
                                            <img src="{{ $mentor->contact->user->profile->headshotImage->getURL('medium') }}" class="responsive-img circle" />
                                        @else
                                            <i class="fa fa-user fa-2x"></i>
                                        @endif
                                    </div>
                                    <div class="col m8 left-align">
                                        <h4><a class="no-underline">{{ $mentor->contact->getName() }}</a></h4>
                                        <p>{{ $mentor->title }}</p>
                                        <br />
                                        <p>{{ $mentor->description }}</p>
                                    </div>
                                </div>
                                @if ($index == 0 || $index % 2) 
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
