@extends('layouts.default')
@section('title', 'Services')
@section('hero')
    <div class="row hero sbs-hero bg-image transparent-box training-consulting">
        <div class="col s12 m6 offset-m2">
            <div style="margin-top:-20px;">
                <h2 class="header" style="max-width:550px;min-width:300px;">Our services</h2>
                <h3 class="header" style="max-width:550px;min-width:300px;font-size:1.2em">We teach B2B and B2C systems and work with reps and leaders at all levels. With our experience as sellers, managers, and trainers, we are well equipped to handle all your sales development needs.</h3>
                <div style="display: grid;grid-template-columns: 185px auto;">
                    <h5><a class="no-underline sbs-arrow-link" href="#areas-of-expertise">See our services</a></h5>
                    <h5><a class="no-underline sbs-arrow-link" href="#areas-of-expertise"><img src="/images/sbs-red-arrow-right.png" style="width:50px;margin-top:5px;"></a></h5>
                    <h5><a class="no-underline sbs-arrow-link" href="/clients">Meet our clients</a></h5>
                    <h5><a class="no-underline sbs-arrow-link" href="/clients"><img src="/images/sbs-red-arrow-right.png" style="width:50px;margin-top: 5px;"></a></h5>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 center-align" style="margin-top: 20px">
            <a name="why"><h4>Why work with us?</h4></a>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <div style="width: 20%; float: left; padding-top: 10px; font-size: 120px; line-height: 100px; font-weight: 300; color: #aaaaaa;">1</div>
            <div style="width: 80%; float: left;">
                <h5 class="sbs-red-text">We sat in the seat.</h5>
                <p>We have 15+ years of sales, leadership, and strategy experience and because we did the job we can speak the sales language across all industries and levels.</p>
            </div>
        </div>
        <div class="col s12 m6">
            <div style="width: 20%; float: left; padding-top: 10px; font-size: 120px; line-height: 100px; font-weight: 300; color: #aaaaaa;">2</div>
            <div style="width: 80%; float: left;">
                <h5 class="sbs-red-text">We build it together.</h5>
                <p>Because your challenges are unique we customize our training content with you prior to each session. When training we act as a sales coach, tapping into your team members’ knowledge and working alongside them to create a training program that yields results.</p>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 60px;">
        <div class="col s12 m6">
            <div style="width: 20%; float: left; padding-top: 10px; font-size: 120px; line-height: 100px; font-weight: 300; color: #aaaaaa;">3</div>
            <div style="width: 80%; float: left;">
                <h5 class="sbs-red-text">We share and evolve.</h5>
                <p>We get feedback after every engagement and work hard to keep improving. We have an appetite to learn and grow just like you do. Working with us guarantees you’re getting a more modern and innovative approach to achieving success.</p>
            </div>
        </div>
        <div class="col s12 m6">
            <div style="width: 20%; float: left; padding-top: 10px; font-size: 120px; line-height: 100px; font-weight: 300; color: #aaaaaa;">4</div>
            <div style="width: 80%; float: left;">
                <h5 class="sbs-red-text">We do it as a team.</h5>
                <p>We get involved in the sales process. We don’t just show your team how to do it, we work alongside them to ensure the methods we teach make it into the field.</p>
            </div>
        </div>
    </div>
    <div class="row white-text" id="areas-of-expertise" style="margin:30px 0px 75px 0px;">
        <div class="col s12" style="background-color: #CE2A25; background-size: cover;">
            <h3 class="center-align" style="margin-top: 30px;font-weight: 600;">Our Professional Services</h3>
            <div class="row" style="margin: 0 7vw;font-size: 1.1em; display:flex; justify-content: space-evenly;">
                <div>
                    <ul class="bullets">
                        <li>Basic sales training and skill development</li>
                        <li>1:1 sales rep coaching</li>
                        <li>Strategic campaign consulting</li>
                        <li>Live call observation</li>
                        <li>Leadership training</li>
                    </ul>
                </div>
                <div>
                    <ul class="bullets">
                        <li>Marketing and strategy consulting</li>
                        <li>Social selling</li>
                        <li>Sales 2.0 best practices</li>
                        <li>Full cycle B2B & B2C sales development</li>
                        <li>Pipeline management</li>
                    </ul>
                </div>
            </div>
            <div class="row" style="margin: 20px auto;">
                <div class="col s12 center-align">
                    <a href="/contact" class="btn btn-large white-outline no-underline">Let's get started</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
