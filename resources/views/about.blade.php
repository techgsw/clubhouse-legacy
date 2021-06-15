@extends('layouts.default')
@section('title', 'About')
@section('hero')
    <div class="row hero sbs-hero bg-image transparent-box about">
        <div class="col s12 m6 offset-m2">
            <h2 class="header" style="max-width:550px;min-width:300px;">Our team is here to support and guide your team Lorem ipsum dolor sit amet, consectetur</h2>
            <br>
            <h5><a class="no-underline sbs-arrow-link" href="#sbs-team">Meet the team&nbsp;&nbsp;<img src="/images/sbs-red-arrow-right.png" style="width:50px;"></a></h5>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col s12 m6" style="color:#575757">
            <div style="max-width:600px;margin-bottom:50px;">
                <h4>Who we are</h4>
                <p style="font-size:1.2rem">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat</p>
                <br>
                <h5><a class="no-underline sbs-arrow-link" href="/training-consulting">Our services&nbsp;&nbsp;<img src="/images/sbs-red-arrow-right.png" style="width:50px;"></a></h5>
                <br>
                <h5><a class="no-underline sbs-arrow-link" href="#">Our clients&nbsp;&nbsp;<img src="/images/sbs-red-arrow-right.png" style="width:50px;"></a></h5>
            </div>
        </div>
        <div class="col s12 m6" style="text-align: center;">
            <img src="/images/about/who-we-are.jpg" style="width:450px;box-shadow:25px 25px;">
        </div>
    </div>
</div>
<div class="container">
    <hr style="margin-top:75px;border:1px solid #DDD;">
</div>
<div id="sbs-team" class="container" style="padding:45px 0px;">
    <div class="row" style="margin-bottom:40px;">
        <h4 class="center-align" style="font-weight:600;">Meet our founder</h4>
    </div>
    <div class="row">
        <div class="about-cards">
            <div class="about-card">
                <a href="/bob-hamer" class="no-underline" style="display: flex;justify-content: center;align-items: center;">
                    <img src="/images/about/bob.png" style="max-width: 210px; border-radius: 50%;">
                    <h3 style="text-align: left; margin-left:3vw;">Bob Hamer<span class="about-position">Founder &amp; President</span></h3>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="sbs-core-values">
    <div class="container">
        <h4 style="padding:50px 0px;">Our core values</h4>
        <div class="row">
            <div class="col s12 m6">
                <div class="sbs-core-value-card">
                    <h4>Integrity</h4>
                    <p>ex ea commodo consequauat. Duis ato irure dolor in reprehenferit in voluptate velit</p>
                </div>
                <div class="sbs-core-value-card">
                    <h4>Work Ethic</h4>
                    <p>ex ea commodo consequauat. Duis ato irure dolor in reprehenferit in voluptate velit</p>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="sbs-core-value-card">
                    <h4>Passion</h4>
                    <p>ex ea commodo consequauat. Duis ato irure dolor in reprehenferit in voluptate velit</p>
                </div>
                <div class="sbs-core-value-card">
                    <h4>Teamwork</h4>
                    <p>ex ea commodo consequauat. Duis ato irure dolor in reprehenferit in voluptate velit</p>
                </div>
            </div>
        </div>
    </div>
</div>
@include('contact-us.form')
@endsection
