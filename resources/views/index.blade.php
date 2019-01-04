@extends('layouts.default')
@section('title', 'Careers in Sports')
@section('hero')
    <div class="row hero bg-image home">
        <div class="col s12 m8 offset-m2">
            <h4 class="header">At Sports Business Solutions, we help people succeed in sports business.</h4>
            <p>We provide Training, Consulting, and Recruiting services for sports teams and provide Career Services for those interested in working in sports.</p>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 center-align">
            <h3 class="heavy">Let's get started</h3>
        </div>
    </div>
    <div class="row hide-on-med-and-up">
        <div class="col s12 center-align">
            <a href="/services" class="btn sbs-red">I'm at a sports team</a>
        </div>
    </div>
    <div class="row hide-on-med-and-up">
        <div class="col s12 center-align">
            <a href="{{ env('CLUBHOUSE_URL') }}/career-services" class="btn sbs-red">I'm a job seeker</a>
        </div>
    </div>
    <div class="row hide-on-small-only">
        <div class="col m6 right-align">
            <a href="/services" class="btn btn-large sbs-red">I'm at a sports team</a>
        </div>
        <div class="col m6 left-align">
            <a href="{{ env('CLUBHOUSE_URL') }}/career-services" class="btn btn-large sbs-red">I'm a job seeker</a>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <a name="clients"><h3>Our Clients Include</h3></a>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <img src="/images/home/clients.png?v=6" alt="" style="margin-bottom: 60px;">
        </div>
    </div>
</div>
<div class="sbs-row">
    <div class="sbs-col-6 bg-img training hide-on-med-and-up"></div>
    <div class="sbs-col-6 gray">
        <h3>Training &amp; Consulting</h3>
        <p>With more than 10 years of sports industry experience and a passion for teaching and coaching we’re excited to help you and your team succeed. Let us know the challenges you’re facing and we’ll work together to provide a solution that helps you accomplish your business objectives and take your team to the next level.</p>
        <div class="input-field">
            <a href="/training-consulting" class="btn btn-large sbs-red">Learn more</a>
        </div>
    </div>
    <div class="sbs-col-6 bg-img training hide-on-small-only"></div>
</div>
<div class="sbs-row">
    <div class="sbs-col-6 bg-img recruiting"></div>
    <div class="sbs-col-6 gray">
        <h3>Recruiting</h3>
        <p>Our experience as former hiring managers in sports gives us unique insight and the right qualifications to find and place best-in-class job candidates. Not only do we have firsthand knowledge of the skills and attributes needed to succeed in sports business jobs, we have established relationships with the future stars of our industry. Let us help you find your next sports industry leader.</p>
        <div class="input-field">
            <a href="/recruiting-3" class="btn btn-large sbs-red">Learn more</a>
        </div>
    </div>
</div>
<div class="sbs-row">
    <div class="sbs-col-6 bg-img services hide-on-med-and-up"></div>
    <div class="sbs-col-6 gray">
        <h3>Career Services</h3>
        <p>More than 300 colleges and universities are now offering degrees in sports management and the demand for jobs in sports has never been higher. We believe that with the right game plan and industry contacts, your dream job in sports is within reach. Let us give you the edge you need to compete for, and land, the most sought after jobs in sports.</p>
        <div class="input-field">
            <a href="{{ env('CLUBHOUSE_URL') }}/career-services" class="btn btn-large sbs-red">Learn more</a>
        </div>
    </div>
    <div class="sbs-col-6 bg-img services hide-on-small-only"></div>
</div>
<div class="container">
    <div class="row" style="padding: 30px 0;">
        <div class="col s12">
            <div class="carousel testimonial carousel-slider center" data-indicators="true">
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/home/testimonial/phoenix_suns.jpg" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Early on in his career with the Suns, Bob exhibited a strong commitment to developing both his craft and the skill sets of those around him. Quickly working his way up the ranks as a sales executive, Bob earned the trust of customers, co-workers, executives and ownership alike. And when he transitioned to a management role, he brought that same level of dedication and commitment to the development of those that he managed. Any person aspiring to succeed in the sports and entertainment business would be well advised to seek Bob’s input and advice.</p>
                                <p class="heavy">
                                    Jason Rowley<br/>
                                    President<br/>
                                    Phoenix Suns &amp; Mercury
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/home/testimonial/connecticut_sun.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Bob has worked his way through the ranks of minor league hockey, WNBA and NBA to sell and then lead sales campaigns at the highest levels. No matter what he was focused on during our time working together at the Suns and Mercury, he was passionate and thorough in developing the most innovative and efficient process to not only meet a goal, but shatter it. Simply put, Bob has the ability to evaluate and develop talent in the sports industry because he has been the best at every level.</p>
                                <p class="heavy">
                                    Amber Cox<br/>
                                    Vice President - Marketing<br/>
                                    Connecticut Sun &amp; NE Black Wolves
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/home/testimonial/sacramento_kings.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>When I decided to pursue a job in sports, one of my very first calls was to Bob. He’s a great friend -- as generous with his expertise and rolodex as he is with his time – and he is always willing to provide valuable guidance and insight. Aspiring sports leaders are incredibly lucky to have Bob as a resource in their corner.</p>
                                <p class="heavy">
                                    Colin Twomey<br/>
                                    Vice President – Product Development &amp; Analytics<br/>
                                    Sacramento Kings
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/home/testimonial/miami_dolphins.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Bob Hamer is a great mentor of mine and someone I hold in the highest regard. An expert in Ticket Sales, Bob has a strong work ethic for driving revenue while helping grow the careers of those around him. Bob’s management experience includes overseeing group, season ticket, and premium sales teams that exceeded sales goals regardless of team performance. His passion for growing careers coupled with his overall professionalism and vast network throughout the sports industry make him stand out amongst his peers. I was fortunate enough to work for Bob for two years with the Phoenix Suns and am privileged to call him a close friend.</p>
                                <p class="heavy">
                                    Dave Baldwin<br/>
                                    Vice President – Ticket Sales &amp; Service<br/>
                                    Miami Dolphins
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
