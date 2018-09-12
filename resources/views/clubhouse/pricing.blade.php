@extends('layouts.clubhouse')
@section('title', 'Clubhouse Pricing')
@section('hero')
    <div class="row hero bg-image services">
        <div class="col s12">
            <h4 class="header">Pricing</h4>
            <p>The Clubhouse is the new home for aspiring and current sports business professionals to network, learn and grow their career in sports.</p>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 center-align">
                <h5>There are many opportunities when it comes to careers in sports. That's why we've gathered all possiblities just for you.</h5>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12 center-align" style="padding: 10px 0 50px 0;">
                            <h5><strong>The Clubhouse Community - Free</strong></h5>
                            <p>Get into the game and be a part of our sports business community.</p>
                            <ul class="">
                                <li>Apply to open jobs</li>
                                <li>Access our blog content and industry resources</li>
                                <li>Purchase career services</li>
                                <li>Receive our periodic e-Newsletter</li>
                            </ul>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            <a href="/" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="card">
                    <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12 center-align" style="padding: 10px 0 50px 0;">
                            <h5><strong>The Clubhouse Pro - $7/month</strong></h5>
                            <p>Ideal for those looking for hands on opportunities and networking access to launch or transform their career in sports.</p>
                            <ul class="">
                                <li>Exclusive 1:1 mentorship with industry professionals</li>
                                <li>Exclusive access to webinars and events,, featuring hot industry topics and hosted by some of the best and brightest minds in sports biz</li>
                                <li>50% off all 1:1 career services (save $15 to $150!)</li>
                                ne free 30 minute career Q&A with a member of our executive team
                                <li>Access to our monthly webinar for career coaching, hosted by the Sports Business Solutions team</li>
                            </ul>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            <a href="#" class="btn sbs-red" style="margin-top: 20px;"> Checkout now</a>
                            <a href="{{ $product->options()->first()->getURL(false, 'checkout') }}" class="buy-now btn sbs-red" style="margin-top: 18px;">Become a Member</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
