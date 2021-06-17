@extends('layouts.default')
@section('title', 'Clients')
@section('hero')
    <div class="row hero sbs-hero bg-image transparent-box clients-hero">
        <div class="col s12 m6 offset-m2">
            <h2 class="header" style="max-width:550px;min-width:300px;">Our client partners</h2>
            <h3 class="header" style="max-width:550px;min-width:300px;">Working alongside amazing leaders, sellers, and organizations is our “why” and we feel so blessed to do what we do. Thanks to all of you for putting your trust in us.</h3>
            <br>
            <h5><a class="no-underline sbs-arrow-link" href="#testimonials">Hear their stories&nbsp;&nbsp;<img src="/images/sbs-red-arrow-right.png" style="width:50px;"></a></h5>
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
<div class="container center-align">
    <h5 style="font-weight:600;text-transform: uppercase;">Sports &amp; entertainment partners</h5>
    <div class="row center-align clients" style="max-width:800px;margin:40px auto;">
        <div class="col s12" style="display:flex;align-items:center;justify-content:center;flex-wrap:wrap;">
            <img class="logo" src="/images/clients/kansas_city.png" alt="Kansas City Chiefs" style="height:80px;">
            <img class="logo" src="/images/clients/angels.png" alt="Los Angeles Angels" style="height:90px;">
            <img class="logo" src="/images/clients/golden-state-warriors.png" alt="Golden State Warriors" style="height:100px;">
            <img class="logo" src="/images/clients/titans.png" alt="Tennessee Titans" style="height:90px;">
            <img class="logo" src="/images/clients/oneworld_observatory.png" alt="One World Observatory" style="height:90px;">
            <img class="logo" src="/images/clients/dc_united.png" alt="DC United" style="height:90px;">
            <img class="logo" src="/images/clients/pittsburgh-penguins.png" alt="Pittsburgh Penguins" style="height:90px;">
            <img class="logo" src="/images/clients/nascar.png" alt="Nascar" style="height:75px;">
        </div>
    </div>
</div>
<div class="container center-align" style="margin: 80px auto;">
    <h5 style="font-weight:600;text-transform: uppercase;">Tech &amp; SaaS Sales Partners</h5>
    <div class="row center-align clients" style="max-width:1100px;margin:40px auto;">
        <div class="col s12" style="display:flex;align-items:center;justify-content:center;flex-wrap:wrap;">
            <img class="logo" src="/images/clients/classpass.png" alt="ClassPass" style="height:100px;">
            <img class="logo" src="/images/clients/brex.png" alt="Brex" style="height:45px;">
            <img class="logo" src="/images/clients/lyra.png" alt="Lyra" style="height:70px;">
            <img class="logo" src="/images/clients/routeware.png" alt="Routeware" style="height:60px;">
            <img class="logo" src="/images/clients/pluralsight.png" alt="Pluralsight" style="height:70px;">
            <img class="logo" src="/images/clients/planet_dds.png" alt="Planet DDS" style="height:70px;">
            <img class="logo" src="/images/clients/hootology.JPG" alt="Hootology" style="height:80px;">
            <img class="logo" src="/images/clients/reputationdotcom.png" alt="Reputation.com" style="height:50px;">
        </div>
    </div>
</div>
<div class="row center-align">
    <a href="#clients-modal" class="btn btn-large sbs-red modal-trigger" style="margin:10px;">See all of our partners</a>
    <a href="#contact-us" class="btn btn-large sbs-red" style="margin:10px;">Become a partner</a>
</div>
@include('components.clients-modal')
<div id="testimonials" class="row" style="padding: 80px 0 30px 0;">
    <div class="carousel testimonial carousel-slider center" data-indicators="true">
        <div class="carousel-item center-align" href="#">
            <div class="row">
                <img class="logo" src="/images/clients/sd_padres.png" alt="San Diego Padres">
            </div>
            <div class="testimonial-bg">
            <div class="row testimonial-content">
                <p style="font-size:1.5em">"We had Bob out to San Diego after I transitioned into my new role. His insights helped both the staff and me set the tone for the upcoming season. Our staff benefitted most from the one-on-one settings where he could dive into each of their books of business and look for areas of opportunity. This coupled with his extensive background in the NBA and their best practices really opened our reps' eyes to what other programs are out there. For me, getting an opportunity to spend time with Bob and talk through short- and long-term strategy allowed me to focus on what was important right now as well as what's coming next."</p>
                <p class="heavy">
                    - Curt Waugh, Vice President - Ticket Sales &amp; Membership Services at the San Diego Padres
                </p>
            </div>
            </div>
        </div>
        <div class="carousel-item center-align" href="#">
            <div class="row">
                <img class="logo" src="/images/clients/classpass.png" alt="ClassPass">
            </div>
            <div class="testimonial-bg">
            <div class="row testimonial-content">
                <p>"Bob's sales expertise ranges from the high volume one-call-close to the long enterprise sales cycle and everything in between. Not only is he a master of his craft, he is approachable, professional, and encouraging and truly makes us all feel like he's a part of our team and genuinely wants our company and sales org to succeed. It's hard to find an external sales trainer that every salesperson admires, but we've found it in Bob."</p>
                <p class="heavy">
                    - Kinsey Livingston, Vice President of Partnerships at ClassPass
                </p>
            </div>
            </div>
        </div>
        <div class="carousel-item center-align" href="#">
            <div class="row">
                <img class="logo" src="/images/clients/pluralsight.png" alt="Pluralsight" style="height:150px;margin-bottom: -95px;">
            </div>
            <div class="testimonial-bg">
            <div class="row testimonial-content">
                <p style="font-size:2em">"Bob did an amazing job coming prepared to the training session. Combining this with his expertise and history of success, I have no hesitation referring him to any sales leader looking to empower and improve their teams skill-set."</p>
                <p class="heavy">
                    - Bryson Poll, Account Executive at Pluralsight
                </p>
            </div>
            </div>
        </div>
        <div class="carousel-item center-align" href="#">
            <div class="row">
                <img class="logo" src="/images/clients/brex.png" alt="Brex" style="height:130px; margin-bottom: -75px;">
            </div>
            <div class="testimonial-bg">
            <div class="row testimonial-content">
                <p>"Bob recently worked with our SDR and AE teams to help develop cold call outreach. The training was very well put together, interactive, and kept everyone engaged. Bob brought in a very fresh and new perspective that challenged the way we had been doing things. It's only been a few weeks since working with Bob and we're already seeing longer call times, more qualification being done upfront, and an increased show rate. I recommend getting Bob and the SBS team in front of your sales team ASAP."</p>
                <p class="heavy">
                    - Brandon Boyle, Sales Manager at Brex
                </p>
            </div>
            </div>
        </div>
        <div class="carousel-item center-align" href="#">
            <div class="row">
                <img class="logo" src="/images/clients/utah_jazz.png" alt="Utah Jazz">
            </div>
            <div class="testimonial-bg">
            <div class="row testimonial-content">
                <p style="font-size:1.25em">"I've known Bob Hamer since we entered the sports industry together with the Phoenix Suns over a decade ago. From those early days as reps “smiling and dialing” to today, Bob has always had a genuine desire to help people. Whether it was assisting his clients or coworkers back then, or helping aspiring professionals or teams in achieving their goals today, Bob's dedication to others and commitment to excellence have been exemplary. We partnered with Bob to do some sales training earlier this year, and our staff enjoyed his down-to-earth approach in presenting the skills and techniques necessary to thrive in sales. They also appreciated the real-life examples and practical solutions he used to illustrate what was being taught. If you have any training, consulting or recruiting needs, I highly recommend Bob and his SBS team."</p>
                <p class="heavy">
                    - Colby Zobell,<br/>
                    Former: Director, Sales & Service Academy at the Utah Jazz<br/>
                    Currently: Director of Ticket Sales at the San Diego Seals
                </p>
            </div>
            </div>
        </div>
        <div class="carousel-item center-align" href="#">
            <div class="row">
                <img class="logo" src="/images/clients/arizona_diamondbacks.png" alt="Arizona Diamondbacks">
            </div>
            <div class="testimonial-bg">
            <div class="row testimonial-content">
                <p style="font-size:1.45em">"We decided to partner with Bob Hamer for our training needs because we felt there was great value in his hands-on experience as a past sports sales professional who worked his way from an entry sales rep to a leadership role as a Vice President. His experience brings credibility that separates him from other trainers and it is that credibility which created immediate buy-in from our staff. Bob has been conducting ongoing training with us over a long-term period of many months. We felt it was important for our reps to have constant and consistent sales training with the same facilitator in order to truly change behavior. He has been a valuable resource for our organization and will continue to be a key part of our training strategies in the future."</p>
                <p class="heavy">
                    - John Fisher, Senior Vice President, Ticket Sales &amp; Marketing at the Arizona Diamondbacks
                </p>
            </div>
            </div>
        </div>
    </div>
</div>
<div id="contact-us">
    @include('contact-us.form')
</div>
@endsection
