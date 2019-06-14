@extends('layouts.clubhouse')
@section('title', 'Clubhouse Membership Options')
@section('hero')
    <div class="row hero bg-image membership-options">
        <div class="col s12">
            <h4 class="header">Job Listing Options</h4>
            <p>Where the industry goes for sports business professionals</p>
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
            <div class="card-flex-container">
                <div class="card medium">
                    <div class="card-content" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong><span class="sbs-red-text">Free</span></strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px;">Listing up for 30 days or until filled.</p>
                                <ul class="fa-check-override">
                                    <li>Hosted on <span class="sbs-red-text">the</span>Clubhouse</li>
                                    <li>General marketing and promotion of the job board</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if (Auth::guest())
                                <a href="/register" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @else
                                <!-- <a href="/user/{{ Auth::user()->id }}/edit-profile" class="btn sbs-red" style="margin-top: 20px;"> Get started</a> -->
                                <a href="job/create" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card medium">
                    <div class="card-content" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong>PLUS</strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px;"><strong>$250</strong> listing up for 60 days or until filled.</p>
                                <ul class="fa-check-override">
                                    <li>Hosted on <span class="sbs-red-text">the</span>Clubhouse</li>
                                    <li>General marketing and promotion of the job board</li>
                                    <li>Featured presence on the Job Board</li>
                                    <li>Email promotions</li>
                                    <li>Social Media promotions</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($job_plus)
                                @if (Auth::guest())
                                    <a href="/register" class="buy-now btn sbs-red" style="margin-top: 18px;">Register</a>
                                @else
                                    <a href="{{ $job_plus->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Plus Now</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card medium">
                    <div class="card-content" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12" style="padding: 10px 0 50px 0;">
                            <h5 class="center-align" style="font-size: 24px"><strong>PREMIUM</strong></h5>
                            <hr class="center-align" style="width: 90%; margin-left: 5%;" />
                            <div style="margin-left: 30px; margin-right: 30px; padding-top: 40px;">
                                <p style="font-size: 16px; min-height: 80px;"><strong>$500</strong> listing up for 90 days or until filled.</p>
                                <ul class="fa-check-override">
                                    <li>Hosted on <span class="sbs-red-text">the</span>Clubhouse</li>
                                    <li>General marketing and promotion of the job board</li>
                                    <li>Featured presence on the Job Board</li>
                                    <li>Email promotions</li>
                                    <li>Social Media promotions</li>
                                    <li>SBS assigned recruiter</li>
                                    <li>More quality, more volume, more marketing</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            @if ($job_premium)
                                @if (Auth::guest())
                                    <a href="/register" class="buy-now btn sbs-red" style="margin-top: 18px;">Register</a>
                                @else
                                    <a href="{{ $job_premium->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Go Premium Now</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
