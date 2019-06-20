@extends('layouts.clubhouse')
@section('title', 'Clubhouse Membership Options')
@section('hero')
    <div class="row hero bg-image membership-options">
        <div class="col s12">
            <h4 class="header">Job Posting Options</h4>
            <p>Where the industry goes for sports business professionals</p>
            <a href="#free" class="btn sbs-red">FREE</a>
            <a href="#featured" class="btn sbs-red">FEATURED</a>
            <a href="#platinum" class="btn sbs-red">PLATINUM</a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                @include('layouts.components.messages')
                @include('layouts.components.errors')
            </div>
        </div>
        <div class="row" id="free">
            <div class="col s12">
                <div class="card large" style="height: 100%;">
                    <div class="card-content">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">Free</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px; font-weight: 400;">Do you want to get some additional views on your open job? Try this option out free of charge. There’s no risk and you may find your future hire! Why wait?! Let’s get started today.</p>
                                <ul class="fa-check-override">
                                    <li>Job will be posted on <span class="sbs-red-text">the</span>Clubhouse for 30 days</li>
                                    <li>Job will be included in our general job update newsletter</li>
                                    <li>Job board will be promoted regularly through all social media channels</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if (Auth::guest())
                                <a href="/register?type=employer" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @else
                                <a href="job/create" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="featured">
            <div class="col s12">
                <div class="card large" style="height: 100%;">
                    <div class="card-content" style="">
                        <div class="col s12" style="padding: 10px 0 0px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong>FEATURED</strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px; font-weight: 400;">Interested in getting more of the right candidates quicker?! For <strong>$250</strong> you can supercharge your open job here. With this option your position will be added to our “featured job” section, where you will get additional views and engagement. You’ll also be sent 15 candidates from our database who are qualified for the role based on your search criteria.</p>
                            </div>
                        </div>
                        <div class="col s12 hide-on-med-and-up" style="padding: 10px 0 50px 0;">
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 0px;">
                                <ul class="fa-check-override">
                                    <li>Job will be featured on <span class="sbs-red-text">the</span>Clubhouse for 45 days</li>
                                    <li>Job will be included in our general job update newsletter</li>
                                    <li>Job board will be promoted regularly through all social media channels</li>
                                    <li>Your individual job will be emailed directly to candidates in our database</li>
                                    <li>We will create a custom social media graphic just for your job and promote it directly via all social media channels to maximize exposure</li>
                                    <li>In addition to job applicants that come in, the Sports Business Solutions team will send you 15 additional job candidate matches based on your search criteria</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s6 hide-on-small-only" style="padding: 10px 0 50px 0;">
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 0px;">
                                <ul class="fa-check-override">
                                    <li>Job will be featured on <span class="sbs-red-text">the</span>Clubhouse for 45 days</li>
                                    <li>Job will be included in our general job update newsletter</li>
                                    <li>Job board will be promoted regularly through all social media channels</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s6 hide-on-small-only" style="padding: 10px 0 50px 0;">
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 0px;">
                                <ul class="fa-check-override">
                                    <li>Your individual job will be emailed directly to candidates in our database</li>
                                    <li>We will create a custom social media graphic just for your job and promote it directly via all social media channels to maximize exposure</li>
                                    <li>In addition to job applicants that come in, the Sports Business Solutions team will send you 15 additional job candidate matches based on your search criteria</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($job_featured)
                                @if (Auth::guest())
                                    <a href="/register" class="buy-now btn sbs-red" style="margin-top: 18px;">Register</a>
                                @else
                                    <a href="{{ $job_featured->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Featured</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="platinum">
            <div class="col s12">
                <div class="card large" style="height: 100%;">
                    <div class="card-content" style="">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong>PLATINUM</strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px; font-weight: 400;">Want us to do all the heavy lifting? No problem! For <strong>$500</strong>  we’ll feature your job, promote it heavily via social media, assign candidates and screen them for you. This way, you’ll ensure that when you spend time talking to a candidate, not only are they qualified, but you know they’re interested in your job.</p>
                            </div>
                        </div>
                        <div class="col s12 hide-on-med-and-up" style="padding: 10px 0 50px 0;">
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 0px;">
                                <ul class="fa-check-override">
                                    <li>Job will be featured on <span class="sbs-red-text">the</span>Clubhouse for 60 days</li>
                                    <li>Job will be included in our general job update newsletter</li>
                                    <li>Job board will be promoted regularly through all social media channels</li>
                                    <li>Your individual job will be emailed directly to candidates in our database</li>
                                    <li>We will create a custom social media graphic just for your job and promote it directly via all social media channels to maximize exposure</li>
                                    <li>In addition to job applicants that come in, the Sports Business Solutions team will send you 15 additional job candidate matches based on your search criteria</li>
                                    <li>The Sports Business Solutions’ team of recruiters will screen and pre-qualify your candidate list to help identify the right person for the job</li>
                                    <li>The Sports Business Solutions’ team will send you a minimum of 5 candidates that are not only qualified, but pre-screened and interested in your position</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s6 hide-on-small-only" style="padding: 10px 0 50px 0;">
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 0px;">
                                <ul class="fa-check-override">
                                    <li>Job will be featured on <span class="sbs-red-text">the</span>Clubhouse for 60 days</li>
                                    <li>Job will be included in our general job update newsletter</li>
                                    <li>Job board will be promoted regularly through all social media channels</li>
                                    <li>Your individual job will be emailed directly to candidates in our database</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s6 hide-on-small-only" style="padding: 10px 0 50px 0;">
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 0px;">
                                <ul class="fa-check-override">
                                    <li>We will create a custom social media graphic just for your job and promote it directly via all social media channels to maximize exposure</li>
                                    <li>In addition to job applicants that come in, the Sports Business Solutions team will send you 15 additional job candidate matches based on your search criteria</li>
                                    <li>The Sports Business Solutions’ team of recruiters will screen and pre-qualify your candidate list to help identify the right person for the job</li>
                                    <li>The Sports Business Solutions’ team will send you a minimum of 5 candidates that are not only qualified, but pre-screened and interested in your position</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($job_platinum)
                                @if (Auth::guest())
                                    <a href="/register" class="buy-now btn sbs-red" style="margin-top: 18px;">Register</a>
                                @else
                                    <a href="{{ $job_platinum->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Platinum</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
