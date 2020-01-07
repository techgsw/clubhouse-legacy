@extends('layouts.default')
@section('title', 'Careers in Sports')
@section('hero')
    <div class="row hero bg-image home">
        <div class="col s12 m8 offset-m2">
            <h4 class="header">At SBS, we help people succeed in sports business.</h4>
            <p>We provide sales training, consulting, and recruiting services to sports teams and properties across North America.</p>
            <a href="/services" class="btn btn-large sbs-red">Learn More</a>
            <a href="/#clients-list" class="btn btn-large sbs-red">Our Clients</a>
        </div>
    </div>
@endsection
@section('content')
<div class="sbs-row">
    <div class="sbs-col-6 bg-img training hide-on-med-and-up"></div>
    <div class="sbs-col-6 gray">
        <h3>Training &amp; Consulting</h3>
        <p>With more than 30 years of combined sales experience and a passion for teaching and coaching, we’re excited to help your team succeed. Let us know the challenges you’re facing, and we’ll work together to provide a custom solution that helps you accomplish your business objectives and take your team to the next level.</p>
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
        <h3><span class="sbs-red-text">the</span>Clubhouse</h3>
        <p><span class="sbs-red-text">the</span>Clubhouse is a place where current and aspiring sports industry professionals go to learn, network, browse career opportunities and share best practices in an effort to succeed in the sports industry.</p>
        <div class="input-field">
            <a href="{{ env('CLUBHOUSE_URL') }}" class="btn btn-large sbs-red">Learn more</a>
        </div>
    </div>
    <div class="sbs-col-6 bg-img services hide-on-small-only"></div>
</div>
<div class="container">
    <div id="clients-list" class="row" style="padding: 30px 0 0 0;">
        <div class="col s12 center-align">
            <img src="/images/home/clients.jpg?v=2" alt="">
        </div>
    </div>
</div>
<div class="container">
    <div class="row" style="padding: 30px 0;">
        <div class="col s12">
            <div class="carousel testimonial home carousel-slider center" data-indicators="true">
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/home/testimonial/phoenix-suns-sports-business-solutions.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Bob Hamer is a great mentor of mine and someone I hold in the highest regard. An expert in Ticket Sales, Bob has a strong work ethic for driving revenue while helping grow the careers of those around him. Bob’s management experience includes overseeing group, season ticket, and premium sales teams that exceeded sales goals regardless of team performance. His passion for growing careers coupled with his overall professionalism and vast network throughout the sports industry make him stand out amongst his peers. I was fortunate enough to work for Bob for two years with the Phoenix Suns and am privileged to call him a close friend.</p>
                                <p class="heavy">
                                    Dave Baldwin<br/>
                                    SVP Ticket Sales & Service<br/>
                                    Ilitch Holdings
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
                                <p>I had an amazing experience working with Jason and SBS! They are very personable, knowledgeable, and provided great insight throughout my interview process. Would definitely recommend their guidance from training to interview prep. </p>
                                <p class="heavy">
                                    Aaron Lampkin<br/>
                                    Director of Sales<br/>
                                    Seattle Sounders FC
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/home/testimonial/dc-united-sports-business-solutions.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>I appreciated Josh and SBS coming out and spending time with us. I love the think-tank atmosphere the SBS team brings with them for training. There is nothing better than engaging in conversation about real situations and ideas as a team and then having people like Josh and Bob there to help guide the conversation. We look forward to seeing Josh and the SBS team again for another training session.  </p>
                                <p class="heavy">
                                    Matt Walsh<br/>
                                    Account Executive<br/>
                                    Texas Rangers
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
                                <p>We’ve had the opportunity to work with SBS multiple times with focuses on different areas of our business, and all of their training sessions have been very well received by our staff. They have a unique way of bringing creative and practical sales approaches to our team, which makes it easy to implement following the session. We look forward to working with them again in the future.</p>
                                <p class="heavy">
                                    James Armold<br/>
                                    Vice President Ticket Sales & Service<br/>
                                    D.C. United
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
                                <p>I’ve known Bob Hamer since we entered the sports industry together with the Phoenix Suns over a decade ago. From those early days as reps “smiling and dialing” to today, Bob has always had a genuine desire to help people. Whether it was assisting his clients or coworkers back then or helping aspiring professionals or teams in achieving their goals today, Bob’s dedication to others and commitment to excellence have been exemplary.  </p>
                                <p>We partnered with Bob to do some sales training earlier this year, and our staff really enjoyed his down-to-earth approach in presenting the skills and techniques necessary to thrive in sales. They also appreciated the real-life examples and practical solutions he used to illustrate what was being taught.</p>
                                <p>If you have any training, consulting or recruiting needs, I highly recommend Bob and his SBS team.</p>
                                <p class="heavy">
                                    Colby Zobell<br/>
                                    Director, Sales & Service Academy<br/>
                                    Utah Jazz
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
