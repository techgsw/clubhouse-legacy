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
                    <div class="carousel carousel-slider center" data-indicators="true" style="height: 300px;">
                        @if (count($mentors) > 0)
                            @foreach ($mentors as $index => $mentor)
                                @if ($index % 2 == 0) 
                                    <div class="carousel-item" style="min-height: 300px;" href="#">
                                        <div class="row">
                                @endif
                                <div class="col s6">
                                    <div class="col m5">
                                        @if ($mentor->contact->headshotImage)
                                            <img src="{{ $mentor->contact->headshotImage->getURL('medium') }}" class="responsive-img circle"/>
                                        @elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
                                            <img src="{{ $mentor->contact->user->profile->headshotImage->getURL('medium') }}" class="responsive-img circle" />
                                        @else
                                            <i class="fa fa-user fa-2x"></i>
                                        @endif
                                    </div>
                                    <div class="col m7 left-align">
                                        <h4 style="margin-bottom: 0px;"><a class="no-underline">{{ $mentor->contact->getName() }}</a></h4>
                                        <p style="margin-top: 0px; margin-bottom: 0px;"><strong>{{ $mentor->contact->getTitle() }}</strong></p>
                                        <p style="margin-top: 5px;">{{ $mentor->description }}</p>
                                    </div>
                                </div>
                                @if ($index != 0 || $index == count($mentors) - 1) 
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center-align" style="padding-bottom: 50px;">
                    <a href="/mentor" class="btn sbs-red" style="margin-top: 0px;"> Find you mentor</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 center-align">
                <img class="" style="width: 100px; margin-top: 50px;" src="/images/clubhouse/job-board.png" />
                <h3>Job Board</h3>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6 offset-m3 center-align">
                <h5>There are many opportunities when it comes to careers in sports. That's why we've gathered all possiblities just for you.</h5>
            </div>
        </div>
        <div class="row">
            @if (count($jobs) > 0)
                @foreach ($jobs as $index => $job)
                    <div class="col s12 m4">
                        <div class="card">
                            <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;">
                                <a href="/job/{{ $job->id }}" style="flex: 1 0 auto; display: flex; flex-flow: column; justify-content: center;" class="no-underline">
                                    <img style="width: 120px; margin: 0 auto;" src="{{ $job->image->getURL('medium') }}" />
                                </a>
                                <div class="col s12 center-align" style="padding: 10px 0 50px 0;">
                                    <a href="/job/{{$job->id}}">
                                        <h5>{{ $job->title }}</h5>
                                        <p><span class="heavy">{{ $job->organization_name }}</span> in {{ $job->city }}, {{ $job->state }}, {{ $job->country }}</p>
                                    </a>
                                    <p><strong>{{ $job->name}}</strong></p>
                                    <a href="/job/{{$job->id}}" class="btn sbs-red" style="margin-top: 20px;"> Apply now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col s12 center-align">
                    <h4>Coming soon.</h4>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col s12 center-align" style="padding-bottom: 50px;">
                <a href="/job" class="btn sbs-red" style="margin-top: 20px;"> Browse open jobs</a>
            </div>
        </div>
    </div>
    <div class="fill-grey">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <img class="" style="width: 100px; margin-top: 50px;" src="/images/clubhouse/event.png" />
                    <h3>Webinars</h3>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6 offset-m3 center-align">
                    <h5>Learn and network with sports professionals in a fun and interactive way!</h5>
                </div>
            </div>
            <div class="row center-align valign-wrapper" style="margin-bottom: 0;">
                <div class="col s2 m4">
                    <hr style="border: 1px solid;" />
                </div>
                <div class="col s8 m4">
                    <p style="font-size: 20px; color: #9E9E9E;">Upcoming Events</p>
                </div>
                <div class="col s2 m4">
                    <hr style="border: 1px solid;" />
                </div>
            </div>
            <div class="row center-align">
                @if (count($webinars) > 0)
                    @foreach ($webinars as $index => $webinar)
                        <div class="col s12 m4">
                            <div class="card bg-image dark-circle fill-grey">
                                <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;">
                                @if ($webinar->primaryImage())
                                    <a href="/product/{{ $webinar->id }}" style="flex: 1 0 auto; display: flex; flex-flow: column; justify-content: center;" class="no-underline">
                                        <img class="responsive-img" style="max-height: 80px; margin: -20px auto 0 auto;" src="{{ $webinar->primaryImage()->getURL('medium') }}" />
                                    </a>
                                @endif
                                    <p><strong>{{ $webinar->name}}</strong></p>
                                    <p style="margin-bottom: 20px;">{{ $webinar->description }}</p>
                                    <a href="" class="no-underline"><strong>RSVP NOW </strong><i class="material-icons small" style="vertical-align: bottom; font-size: 22px;">chevron_right</i></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col s12 center-align">
                        <h4>Coming soon.</h4>
                    </div>
                @endif
            </div>
            <div class="row" style="margin-bottom: 0;">
                <div class="col s12 center-align" style="padding-bottom: 50px;">
                    <a href="/webinarss" class="btn sbs-red" style="margin-top: 20px;"> See all events</a>
                </div>
            </div>
        </div>
    </div>
    <div class="fill-dark-grey">
        <div class="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row center-align">
                <div class="col s12 m6 border-right">
                    <div class="col s12 m4 offset-m4">
                        <img class="responsive-img" src="/images/clubhouse/career-services.png" />
                    </div>
                    <div class="col s12">
                        <h4>Career Services</h4>
                        <p>Want some 1:1 individual and customized career coaching? Our Clubhouse members are seasoned industry professionals and committed helping you achieve success in sports.</p>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="col s12 m4 offset-m4">
                        <img class="responsive-img" src="/images/clubhouse/resources.png" />
                    </div>
                    <div class="col s12">
                        <h4>Resources</h4>
                        <p>There's some cool stuff out there that helped us, and others achieve success in sports. We wanted to share those with you in hopes that they help you too!</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <div class="col s12 center-align" style="padding-bottom: 50px;">
                        <a href="/career-services" class="btn sbs-red" style=""> Browse career services</a>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="col s12 center-align" style="padding-bottom: 50px;">
                        <a href="/resources" class="btn sbs-red" style=""> Sports industry resources</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
