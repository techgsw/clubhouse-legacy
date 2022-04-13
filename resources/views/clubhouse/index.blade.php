@extends('layouts.clubhouse')
@section('title', 'Sports Industry Resource')
@section('hero')
    <div class="row hero bg-image clubhouse">
        <img src="/images/CH_logo-compass.png"/>
        <h1 class="header">Welcome to theClubhouse<sup>&#174;</sup></h1>
        <h5 style="max-width:800px;margin-right:auto;margin-left:auto;">Your destination for networking, best practices, and career growth in sports business.</h5>
        @can('view-clubhouse')
            <h5><strong>Thank you for being a Clubhouse PRO member!</h5>
        @else
            @if (Auth::user())
                <a href="/pro-membership" class="btn btn-large sbs-red" style="margin-top:20px;margin-bottom: -20px;">Become PRO with a {{CLUBHOUSE_FREE_TRIAL_DAYS}}-day free trial</a>
            @else
                <a href="#register-modal" class="btn btn-large sbs-red" style="margin-top:20px;margin-bottom: -20px;">Join the community</a>
            @endif
        @endcan
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
        <div class="row" style="display: flex; flex-direction: row; flex-wrap:wrap;justify-content: center;">
            <div class="col center-align clubhouse-option">
                <a href="/job" class="no-underline"><img src="/images/clubhouse/CH_Job1.jpg" /></a>
                <p class="option-title"><strong>Check out the Job Board</strong></p>
                <p class="option-description">Your next career opportunity in sports is just a click away.</p>
                <a href="/job" class="red-hover btn clubhouse-option">See job listings</a>
            </div>
            <div class="col center-align clubhouse-option">
                <a href="/register/pro" class="no-underline"><img src="/images/clubhouse/pro-image.png" /></a>
                <p class="option-title"><strong>Become a Pro Member</strong></p>
                <p class="option-description">In depth career building, connect with industry pros, watch webinars, and get training.</p>
                <a href="/regsiter/pro" class="red-hover btn clubhouse-option pro-modal">Get started now</a>
            </div>
            <div class="col center-align clubhouse-option">
                <a href="/mentor" class="no-underline"><img src="/images/clubhouse/mentor.png" /></a>
                <p class="option-title"><strong>Mentorship from the Sports Pros</strong></p>
                <p class="option-description">Gain mentorship from more than 140 sports industry professionals.</p>
                <a href="/mentor" class="red-hover btn clubhouse-option">Find a mentor</a>
            </div>
            <div class="col center-align clubhouse-option">
                <a href="/sales-vault" class="no-underline"><img src="/images/clubhouse/CH_SalesVault1.jpg" /></a>
                <p class="option-title"><strong>Training Vault</strong></p>
                <p class="option-description">Industry leaders share training tips to help you succeed.</p>
                <a href="/sales-vault" class="red-hover btn clubhouse-option">Get training now</a>
            </div>
            <div class="col center-align clubhouse-option">
                <a href="/webinars" class="no-underline"><img src="/images/clubhouse/webinar.png" /></a>
                <p class="option-title"><strong>Live and On-Demand Webinars</strong></p>
                <p class="option-description">Learn from the pros. Attend live events and watch 80+ past webinars on demand.</p>
                <a href="/webinars" class="red-hover btn clubhouse-option">See all events</a>
            </div>
            <div class="col center-align clubhouse-option">
                <a href="/same-here" class="no-underline"><img src="/images/clubhouse/CH_SameHere1.jpg" /></a>
                <p class="option-title"><strong>#SameHere Solutions</strong></p>
                <p class="option-description">Learn how you can maintain your mental health in and out of the front office.</p>
                <a href="/same-here" class="red-hover btn clubhouse-option">Find out more</a>
            </div>


        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="card-flex-container" id="clubhouse-benefits" style="margin-top:50px;">
                <div class="card large" style="height:100%;margin-bottom: 90px;">
                    @if (!Auth::user())
                        <a href="#register-modal" class="no-underline">
                            <div class="card-image" style="background-color: #EB2935;color:#FFF;">
                                <h5 class="center-align" style="font-weight: 600;">Join theClubhouse<sup>&#174;</sup> Community</h5>
                            </div>
                        </a>
                    @else
                        <div class="card-image" style="background-color: #EB2935;color:#FFF;">
                            <h5 class="center-align" style="font-weight: 600;">Your FREE Clubhouse Community Benefits</h5>
                        </div>
                    @endif
                    <div class="card-content" style="background-color: #F6F6F6; max-height: 100%;">
                        <div class="col s12">
                            <h5 class="center-align" style="margin-bottom: 35px;"><strong>Get into the game!<br>Join <span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup> community.</strong></h5>
                            <div style="margin-left: 30px; margin-right: 30px;">
                                <ul class="fa-check-override">
                                    <li>Attend sports industry webinars</li>
                                    <li>Access the sports job board</li>
                                    <li>Get best practices by reading our blog</li>
                                    <li>Maintain your mental health with #SameHere Solutions</li>
                                    <li>Stay up to date with <span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup> newsletter</li>
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
                <div class="card large" style="height:100%;margin-bottom: 90px;">
                    @cannot ('view-clubhouse')
                        <a href="{{Auth::user() ? '/pro-membership' : '/register/pro'}}" class="no-underline">
                            <div class="card-image" style="background-color: #EB2935;color:#FFF;">
                                <h5 class="center-align" style="font-weight: 600;">Become a Clubhouse PRO Member</h5>
                            </div>
                        </a>
                    @else
                        <div class="card-image" style="background-color: #EB2935;color:#FFF;">
                            <h5 class="center-align" style="font-weight: 600;">Your Clubhouse PRO Member Benefits</h5>
                        </div>
                    @endcannot
                    <div class="card-content" style="background-color: #F6F6F6; max-height: 100%;">
                        <div class="col s12">
                            <h5 class="center-align" style="margin-bottom: 35px;"><strong>Take your skills to the next level!<br>Connect with industry pros, watch webinars, and get sales
                                    @cannot('view-clubhouse')
                                        training <span class="sbs-red-text" style="white-space: nowrap;">FREE for {{CLUBHOUSE_FREE_TRIAL_DAYS}} days</span>.
                                    @else
                                        training.
                                    @endcannot
                                </strong>
                            </h5>
                            <div style="margin-left: 30px; margin-right: 30px;">
                                <ul class="fa-check-override">
                                    <li>Everything listed in <span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup> community benefits <i>plus:</i></li>
                                    <li>Sports Career Services including:</li>
                                        <ul class="fa-check-override">
                                            <li>1:1 interview prep and resume coaching</li>
                                            <li>LinkedIn&#8482; profile and personal branding review</li>
                                            <li>Phone consultation to help you navigate tough industry challenges</li>
                                            <li>Career Q&A and action plan</li>
                                        </ul>
                                    <li>Get 1:1 career mentorship with sports industry pros</li>
                                    <li>Access our on-demand Webinar library, with more than 70 hours of content</li>
                                    <li>Enter the Sales Vault – Sales training videos for the sport salesperson</li>
                                    <li>Attend live premium webinars and events</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @cannot('view-clubhouse')
                        <div class="row" style="position:absolute;bottom:-70px;left:10px;display:flex;justify-content: center;width:100%;">
                            <a href="{{Auth::user() ? '/pro-membership' : '/register/pro'}}" class="btn btn-large sbs-red" style="margin-top:20px;margin-bottom: -20px;"><strong>Start your FREE {{CLUBHOUSE_FREE_TRIAL_DAYS}}-day trial</strong></a>
                        </div>
                    @endcannot
                </div>
            </div>
        </div>
    </div>
@endsection
