@extends('layouts.clubhouse')
@section('title', 'Sports Industry Resource')
@section('hero')
    <div class="row hero bg-image clubhouse">
        <div class="col s12">
            <img style="max-width: 100px;" src="/images/CH_logo-compass.png"/>
            <h1 class="header">Welcome to The Clubhouse</h1>
            <div class="col s12 m6 offset-m3">
                <h5><span class="sbs-red-text">the</span>Clubhouse is where current and aspiring sports business professionals go to learn, network and share ideas in an effort to grow as both people and professionals.</h5>
                <a href="#register-modal" class="btn btn-large sbs-red" style="margin-top:20px;margin-bottom: -20px;">Sign up for a {{CLUBHOUSE_FREE_TRIAL_DAYS}}-day free trial</a>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row" style="display: flex; flex-direction: row; flex-wrap:wrap;">
            <div class="col center-align red-hover clubhouse-option">
                <img class="" style="height: 100px;" src="/images/clubhouse/event.png" />
                <p><strong>Live and On-Demand Webinars</strong></p>
                <p>Learn from the pros with our playlist of 50+ (and growing) webinars - live and on-demand.</p>
                <a href="/webinars" class="btn clubhouse-option">Check out our library</a>
            </div>
            <div class="col center-align red-hover clubhouse-option">
                <img class="" style="height: 100px;" src="/images/clubhouse/mentorship.png" />
                <p><strong>Mentoring from the Sports Pros</strong></p>
                <p>Get 1:1 mentoring for over 100+ (and growing) sports professionals in the field.</p>
                <a href="/mentor" class="btn clubhouse-option">See who's available</a>
            </div>
            <div class="col center-align red-hover clubhouse-option">
                <img class="" style="height: 100px;" src="/images/clubhouse/career-services.png" />
                <p><strong>Career Services for You</strong></p>
                <p>Schedule a review of your LinkedIn&#8482; profile, get interview coaching, and a bunch more.</p>
                <a href="/career-services" class="btn clubhouse-option">Get started now</a>
            </div>
            <div class="col center-align red-hover clubhouse-option">
                <img class="" style="filter:invert(1);height: 100px;" src="/images/sales-vault/treasure.png" />
                <p><strong>Get in the Sales Training Vault</strong></p>
                <p>The SBS team shared tips based on our professional experiences.</p>
                <a href="/sales-vault" class="btn clubhouse-option">We're ready to talk</a>
            </div>
            <div class="col center-align red-hover clubhouse-option">
                <img class="" style="height: 100px;" src="/images/clubhouse/job-board.png" />
                <p><strong>Check out the Job Board</strong></p>
                <p>These listings for sports sales and services jobs come direct from our contacts.</p>
                <a href="/job" class="btn clubhouse-option">Check out the listings</a>
            </div>
            <div class="col center-align red-hover clubhouse-option">
                <img class="" style="height: 100px;" src="/images/same-here/logo-black-no-title.png" />
                <p><strong>#SameHere Solutions</strong></p>
                <p>Face the challenges that can affect our mental well-being with our consultants.</p>
                <a href="/same-here" class="btn clubhouse-option">Find out more</a>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="card-flex-container" style="margin-top:50px;">
                <div class="card large" style="height:100%;margin-bottom: 90px;">
                    <div class="card-image" style="background-color: #EB2935;color:#FFF;">
                        <h5 class="center-align" style="font-weight: 600;">Join theClubhouse Community</h5>
                    </div>
                    <div class="card-content" style="background-color: #F6F6F6; max-height: 100%;">
                        <div class="col s12">
                            <h5 class="center-align" style="margin-bottom: 35px;"><strong>Get into the game! Join <span class="sbs-red-text">the</span>Clubhouse business community.</strong></h5>
                            <div style="margin-left: 30px; margin-right: 30px;">
                                <ul class="fa-check-override">
                                    <li>LIVE Sports Sales & Service webinars</li>
                                    <li>Sports Industry job BOARD</li>
                                    <li>Sports Industry blog</li>
                                    <li><span class="sbs-red-text">the</span>Clubhouse newsletter</li>
                                    <li>#SameHere Solutions for mental well-being</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="position:absolute;bottom:-70px;left:10px;display:flex;justify-content: center;width:100%;">
                        <a href="#register-modal" class="btn btn-large sbs-red" style="margin-top:20px;margin-bottom: -20px;"><strong>FREE</strong></a>
                    </div>
                </div>
                <div class="card large" style="margin-bottom: 90px;">
                    <div class="card-image" style="background-color: #EB2935;color:#FFF;">
                        <h5 class="center-align" style="font-weight: 600;">Become a Clubhouse PRO Member</h5>
                    </div>
                    <div class="card-content" style="background-color: #F6F6F6; max-height: 100%;">
                        <div class="col s12">
                            <h5 class="center-align" style="margin-bottom: 35px;"><strong>Take your skills to the next level. Connect with industry pros and gain insight you can't get anywhere else.</strong></h5>
                            <div style="margin-left: 30px; margin-right: 30px;">
                                <ul class="fa-check-override">
                                    <li>Everything listed in the Free membership</li>
                                    <li>Career Services including:</li>
                                        <ul class="fa-check-override">
                                            <li>1:1 interview and resume coaching</li>
                                            <li>LinkedIn&#8482; profile review</li>
                                            <li>Phone consultation with hiring managers</li>
                                            <li>Career Q&A and action plan</li>
                                        </ul>
                                    <li>Exclusive 1:1 career mentorship with sports industry professionals</li>
                                    <li>On-demand Sports Industry webinar library with 50+ hours of talking with team executives</li>
                                    <li>Sales Training Vault of how-to videos</li>
                                    <li>30-minute career consultation with Sports Business Solutions President Bob Hamer</li>
                                    <li>Access to additional on-demand premium content</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="position:absolute;bottom:-70px;left:10px;display:flex;justify-content: center;width:100%;">
                        <a href="#register-modal" class="btn btn-large sbs-red" style="margin-top:20px;margin-bottom: -20px;"><strong>FREE {{CLUBHOUSE_FREE_TRIAL_DAYS}}-day trial</strong></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
