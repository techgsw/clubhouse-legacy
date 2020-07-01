@extends('layouts.clubhouse')
@section('title', 'Sports Industry Resource')
@section('hero')
    <div class="row hero bg-image clubhouse">
        <div class="col s12">
            <img style="max-width: 100px;" src="/images/CH_logo-compass.png"/>
            <h1 class="header">Welcome to The Clubhouse</h1>
            <div class="col s12 m6 offset-m3">
                <h5>Where current and aspiring sports business professionals go to learn, network and share ideas in an effort to grow as both people and professionals.</h5>
                @can('view-clubhouse')
                    <h5><strong>We're glad you're a member of <span class="sbs-red-text">the</span>Clubhouse!</strong></h5>
                @else
                    @if (Auth::user())
                        <a href="/pro-membership" class="btn btn-large sbs-red" style="margin-top:20px;margin-bottom: -20px;">Become PRO with a {{CLUBHOUSE_FREE_TRIAL_DAYS}}-day free trial</a>
                    @else
                        <a href="#register-modal" class="btn btn-large sbs-red" style="margin-top:20px;margin-bottom: -20px;">Sign up for a {{CLUBHOUSE_FREE_TRIAL_DAYS}}-day free trial</a>
                    @endif
                @endcan
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row" style="display: flex; flex-direction: row; flex-wrap:wrap;justify-content: center;">
            <div class="col center-align clubhouse-option">
                <img class="" style="height: 100px;" src="/images/clubhouse/CH_Webinar.jpg" />
                <p style="margin-bottom:auto;margin-top:20px;"><strong>Live and On-Demand Webinars</strong></p>
                <p style="min-height:100px;">Learn from the pros with our playlist of 50+ (and growing) webinars - live and on-demand.</p>
                <a href="/webinars" class="red-hover btn clubhouse-option">Check out our library</a>
            </div>
            <div class="col center-align clubhouse-option">
                <img class="" style="height: 100px;" src="/images/clubhouse/CH_Mentor.jpg" />
                <p style="margin-bottom:auto;margin-top:20px;"><strong>Mentoring from the Sports Pros</strong></p>
                <p style="min-height:100px;">Get 1:1 mentoring for over 100+ (and growing) sports professionals in the field.</p>
                <a href="/mentor" class="red-hover btn clubhouse-option">See who's available</a>
            </div>
            <div class="col center-align clubhouse-option">
                <img class="" style="height: 100px;" src="/images/clubhouse/CH_Career.jpg" />
                <p style="margin-bottom:auto;margin-top:20px;"><strong>Career Services for You</strong></p>
                <p style="min-height:100px;">Schedule a review of your LinkedIn&#8482; profile, get interview coaching, and a bunch more.</p>
                <a href="/career-services" class="red-hover btn clubhouse-option">Get started now</a>
            </div>
            <div class="col center-align clubhouse-option">
                <img class="" style="height: 100px;" src="/images/clubhouse/CH_SalesVault.jpg" />
                <p style="margin-bottom:auto;margin-top:20px;"><strong>Get in the Sales Training Vault</strong></p>
                <p style="min-height:100px;">The SBS team shares tips based on our professional experiences.</p>
                <a href="/sales-vault" class="red-hover btn clubhouse-option">We're ready to talk</a>
            </div>
            <div class="col center-align clubhouse-option">
                <img class="" style="height: 100px;" src="/images/clubhouse/CH_Job.jpg" />
                <p style="margin-bottom:auto;margin-top:20px;"><strong>Check out the Job Board</strong></p>
                <p style="min-height:100px;">These listings for sports sales and services jobs come direct from our contacts.</p>
                <a href="/job" class="red-hover btn clubhouse-option">Check out the listings</a>
            </div>
            <div class="col center-align clubhouse-option">
                <img class="" style="height: 100px;" src="/images/clubhouse/CH_SameHere.jpg" />
                <p style="margin-bottom:auto;margin-top:20px;"><strong>#SameHere Solutions</strong></p>
                <p style="min-height:100px;">Face the challenges that can affect our mental well-being, led by Eric Kussin.</p>
                <a href="/same-here" class="red-hover btn clubhouse-option">Find out more</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="card-flex-container" style="margin-top:50px;">
                <div class="card large" style="height:100%;margin-bottom: 90px;">
                    @if (!Auth::user())
                        <a href="#register-modal" class="no-underline">
                    @endif
                            <div class="card-image" style="background-color: #EB2935;color:#FFF;">
                                <h5 class="center-align" style="font-weight: 600;">Join theClubhouse Community</h5>
                            </div>
                    @if (!Auth::user())
                        </a>
                    @endif
                    <div class="card-content" style="background-color: #F6F6F6; max-height: 100%;">
                        <div class="col s12">
                            <h5 class="center-align" style="margin-bottom: 35px;"><strong>Get into the game! Join <span class="sbs-red-text">the</span>Clubhouse community.</strong></h5>
                            <div style="margin-left: 30px; margin-right: 30px;">
                                <ul class="fa-check-override">
                                    <li>Live Sports industry webinars</li>
                                    <li>Access to the Sports Industry job board</li>
                                    <li>Get best practices by reading our blog</li>
                                    <li>Maintain your mental health with #SameHere solutions in sports</li>
                                    <li>Stay up to date with <span class="sbs-red-text">the</span>Clubhouse newsletter</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if (!Auth::user())
                        <div class="row" style="position:absolute;bottom:-70px;left:10px;display:flex;justify-content: center;width:100%;">
                            <a href="#register-modal" class="btn btn-large sbs-red" style="margin-top:20px;margin-bottom: -20px;"><strong>Join the community for FREE</strong></a>
                        </div>
                    @endif
                </div>
                <div class="card large" style="margin-bottom: 90px;">
                    @cannot ('view-clubhouse')
                        <a href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" class="no-underline">
                    @endif
                            <div class="card-image" style="background-color: #EB2935;color:#FFF;">
                                <h5 class="center-align" style="font-weight: 600;">Become a Clubhouse PRO Member</h5>
                            </div>
                    @cannot ('view-clubhouse')
                        </a>
                    @endif
                    <div class="card-content" style="background-color: #F6F6F6; max-height: 100%;">
                        <div class="col s12">
                            <h5 class="center-align" style="margin-bottom: 35px;"><strong>Take your skills to the next level. Connect with industry pros and gain insight you can't get anywhere else.</strong></h5>
                            <div style="margin-left: 30px; margin-right: 30px;">
                                <ul class="fa-check-override">
                                    <li>Everything listed in <span class="sbs-red-text">the</span>Clubhouse community benefits <i>plus</i></li>
                                    <li>Sports Career Services including:</li>
                                        <ul class="fa-check-override">
                                            <li>1:1 interview prep and resume coaching</li>
                                            <li>LinkedIn&#8482; profile review and personal branding</li>
                                            <li>Phone consultation to help you navigate tough industry challenges</li>
                                            <li>Career Q&A and action plan</li>
                                        </ul>
                                    <li>Get 1:1 career mentorship with sports industry pros</li>
                                    <li>Access our video library on demand, complete with more than 50 hours of content</li>
                                    <li>Enjoy access to the Sales Vault - Video tips for the sports salesperson</li>
                                    <li>Attend live premium webinars and events</li>
                                    <li>Receive a free 30-minute career consultation with Bob Hamer, President & Founder of Sports Business Solutions and Creator of <span class="sbs-red-text">the</span>Clubhouse</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @cannot('view-clubhouse')
                        <div class="row" style="position:absolute;bottom:-70px;left:10px;display:flex;justify-content: center;width:100%;">
                            <a href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" class="btn btn-large sbs-red" style="margin-top:20px;margin-bottom: -20px;"><strong>Start your FREE {{CLUBHOUSE_FREE_TRIAL_DAYS}}-day trial</strong></a>
                        </div>
                    @endcannot
                </div>
            </div>
        </div>
    </div>
@endsection
