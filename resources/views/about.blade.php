@extends('layouts.default')
@section('title', 'About')
@section('hero')
    <div class="row hero sbs-hero bg-image transparent-box about">
        <div class="col s12 m6 offset-m2">
            <h2 class="header" style="max-width:550px;min-width:300px;">About Us</h2>
            <h3 class="header" style="max-width:550px;min-width:300px;">We have a passion to level up the sales team of the future.</h2>
            <br>
            <div style="display: grid;grid-template-columns: 185px auto;">
                <h5><a class="no-underline sbs-arrow-link" href="#sbs-team">Meet our founder</a></h5>
                <h5><a class="no-underline sbs-arrow-link" href="#sbs-team"><img src="/images/sbs-red-arrow-right.png" style="width:50px;margin-top:5px"></a></h5>
                <h5><a class="no-underline sbs-arrow-link" href="#core-values">Our core values</a></h5>
                <h5><a class="no-underline sbs-arrow-link" href="#core-values"><img src="/images/sbs-red-arrow-right.png" style="width:50px;margin-top:5px"></a></h5>
            </div>
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
                <p style="font-size:1.2rem">Launched in 2014, we are a boutique consultancy with a focus on sales training, leadership development, and strategic consulting. We love to help organizations identify gaps in their game and subsequently work alongside them to build a systemthat bridges those gaps. Interested in giving us a try? Learn more below!</p>
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
<div id="core-values" class="sbs-core-values">
    <div class="container">
        <h4 style="padding:50px 0px;">Our core values</h4>
        <div class="row">
            <div class="col s12 m6">
                <div class="sbs-core-value-card">
                    <h4>Integrity</h4>
                    <p>We always do the right thing and lead by example, regardless of who’s watching. Rest assured; you can trust us working alongside your team.</p>
                </div>
                <div class="sbs-core-value-card">
                    <h4>Work Ethic</h4>
                    <p>Once we identify a scope, we work tirelessly to make sure we overdeliver for you. We don’t stop until you’re satisfied, even if that means going above and beyond.</p>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="sbs-core-value-card">
                    <h4>Passion</h4>
                    <p>This is our secret sauce. We do this work because we love it. We don’t believe in complacency or going through the motions, we give you our all every day.</p>
                </div>
                <div class="sbs-core-value-card">
                    <h4>Teamwork</h4>
                    <p>We don’t want to tell you what to do, we want to build it together, as a team. We’re always seeking feedback, and believe customization and collaboration drives results.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@include('contact-us.form')
@endsection
