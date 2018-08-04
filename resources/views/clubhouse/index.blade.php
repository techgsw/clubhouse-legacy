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
                        <div class="carousel-item" href="#">
                            <div class="row">
                                <div class="col s12 m4">
                                    <img class="logo" src="/images/about/testimonials/seat-geek.png" alt="">
                                </div>
                                <div class="col s12 m8 left-align">
                                    <div class="testimonial-content">
                                        <p>I had the pleasure of hiring Bob Hamer and working with him in Phoenix for the better part of seven years. Bob has a sharp eye for revenue generation and creating systems that enhance results. His ability to identify and hire great talent, as well as teaching this talent to succeed, is first class. I consider Bob a trusted advisor and would want him as part of my team.</p>
                                        <p class="heavy">
                                            Jeff Ianello<br/>
                                            Executive Vice President, Client Partnerships<br/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" href="#">
                            <div class="row">
                                <div class="col s12 m4">
                                    <img class="logo" src="/images/about/testimonials/usf-bulls.png" alt="">
                                </div>
                                <div class="col s12 m8 left-align">
                                    <div class="testimonial-content">
                                        <p>Bob Hamer has a unique perspective to offer young men and women hoping to work in the sport industry. He has progressed from an entry level sales person to a Vice President responsible for generating millions of dollars in revenue. In his role he has recruited, trained and developed successful professionals and has a real understanding of what it takes to be successful in sport business. His experience, concern, empathy and ability to communicate effectively make him uniquely qualified to provide direction and career advice. I can think of very few people with the credibility and interest in helping young people more than Bob Hamer. He will make a difference in people’s lives.</p>
                                        <p class="heavy">
                                            Dr. William (Bill) Sutton<br/>
                                            Professor & Director, Sports Management<br/>
                                            University South Florida
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item" href="#">
                            <div class="row">
                                <div class="col s12 m4">
                                    <img class="logo" src="/images/about/testimonials/arizona-diamondbacks.png" alt="">
                                </div>
                                <div class="col s12 m8 left-align">
                                    <div class="testimonial-content">
                                        <p>I’ve had the pleasure of knowing and working with Bob Hamer for the last ten years, in that time he has continued to grow and learn each and every day. Now all those lessons he’s learned while working in sports and traveling to visit teams are ready to be passed onto the next generation of industry leaders. The sports business field is highly competitive, and everyone looking for a start should also be looking for an advantage. I cannot think of a better professional to teach, train, recruit, and help place individuals in sports than Bob. His passion to help others learn, grow, and succeed are second to none. I highly recommend Bob to any individuals or teams. If you work with him, I promise you’ll be ahead of the game from that moment on.</p>
                                        <p class="heavy">
                                            Ryan Holmstedt<br/>
                                            Sr. Director, Ticket Sales, Arizona Diamondbacks (MLB)
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
