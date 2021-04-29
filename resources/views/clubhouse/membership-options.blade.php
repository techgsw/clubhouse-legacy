@extends('layouts.clubhouse')
@section('title', 'Clubhouse Membership Options')
@section('hero')
    <div class="row hero bg-image membership-options">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/job-board-white.png" />
            <h4 class="header">Membership Options</h4>
            <p>Your journey to sports industry success starts today! Choose the option that works best for you below.</p>
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
        <div class="row">
            <div class="col s12 center-align">
                <h5>Become a Clubhouse Pro and start your <strong class="sbs-red-text">{{CLUBHOUSE_FREE_TRIAL_DAYS}}-day free trial</strong></h5>
            </div>
        </div>
        <div class="row">
            <div class="card-flex-container">
                <div class="card large">
                    <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup> Community - <span class="sbs-red-text">Free</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px;">Get into the game and join our sports business community.</p>
                                <ul class="fa-check-override">
                                    <li>Attend LIVE educational webinars</li>
                                    <li>Apply to open jobs</li>
                                    <li>Access our educational blog content</li>
                                    <li>Get our newsletter with sports industry updates</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if (Auth::guest())
                                <a href="#register-modal" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @else
                                <a href="/user/{{ Auth::user()->id }}/edit-profile" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card large">
                    <div class="card-content" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup> Pro - <span class="sbs-red-text">Paid</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px;">Take your skills to the next level! Connect with industry pros and gain insight you can't get anywhere else.</p>
                                <ul class="fa-check-override">
                                    <li>Everything listed in the Free membership</li>
                                    <li>Exclusive 1:1 mentorship with sports industry professionals</li>
                                    <li>Access to our webinar archive with more than 40 hours of content</li>
                                    <li>Access to career services to help you build your career in sports</li>
                                    <li>Receive one free 30-minute career consultation</li>
                                    <li>Get pre-access to new jobs in sports</li>
                                    <li>Access to the "Sales vault" sales training videos</li>
                                    <li>Access to additional premium content</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($product)
                                @if (Auth::guest())
                                    <a href="#register-modal" class="buy-now btn sbs-red" style="margin-top: 18px;">Become a Clubhouse Pro</a>
                                @else
                                    <!--<a href="{{ $product->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Become a Clubhouse Pro</a>-->
                                    <a href="/pro-membership" class="buy-now btn sbs-red" style="margin-top: 18px;">Become a Clubhouse Pro</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
