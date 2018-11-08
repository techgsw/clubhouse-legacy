@extends('layouts.clubhouse')
@section('title', 'Clubhouse Membership Options')
@section('hero')
    <div class="row hero bg-image services">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/job-board-white.png" />
            <h4 class="header">Membership Options</h4>
            <p>theClubhouse is the new home for aspiring and current sports business professionals to network, learn and grow their career in sports.</p>
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
                <h5>There are many opportunities when it comes to careers in sports. That's why we've gathered all possiblities just for you.</h5>
            </div>
        </div>
        <div class="row">
            <div class="card-flex-container">
                <div class="card large">
                    <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">the</span>Clubhouse Community - <span class="sbs-red-text">Free</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px;">Get into the game and be a part of our sports business community.</p>
                                <ul class="fa-check-override">
                                    <li>Apply to open jobs</li>
                                    <li>Access our blog content and industry resources</li>
                                    <li>Purchase career services</li>
                                    <li>Receive our periodic e-Newsletter</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if (Auth::guest())
                                <a href="/" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @else
                                <a href="/user/{{ Auth::user()->id }}/edit-profile" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card large">
                    <div class="card-content" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">the</span>Clubhouse Pro - <span class="sbs-red-text">$7/month</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px;">Ideal for those looking for hands on opportunities and networking access to launch or transform their career in sports.</p>
                                <ul class="fa-check-override">
                                    <li>Exclusive 1:1 mentorship with industry professionals</li>
                                    <li>Access to webinars and events, featuring hot industry topics and hosted by some of the best and brightest minds in sports biz</li>
                                    <li>50% off all 1:1 career services (save $15 to $150!)</li>
                                    <li>One free 30 minute career Q&A with a member of our executive team</li>
                                    <li>Access to our monthly webinar for career coaching, hosted by the Sports Business Solutions team</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($product)
                                @if (Auth::guest())
                                    <a href="/" class="buy-now btn sbs-red" style="margin-top: 18px;">Become a Member</a>
                                @else
                                    <a href="{{ $product->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Become a Member</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
