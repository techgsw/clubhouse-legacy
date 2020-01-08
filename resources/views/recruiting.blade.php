@extends('layouts.default')
@section('title', 'Recruiting')
@section('hero')
    <div class="row hero bg-image recruiting">
        <div class="col s12">
            <h4 class="header">Recruiting</h4>
            <p>It’s hard to do great things without great people. Let us help you find your next sports industry leader.</p>
            <a href="#areas-of-expertise" class="btn btn-large sbs-red">Book training now</a>
            <a href="#recruiting-clients" class="btn btn-large sbs-red">Clients & Testimonials</a>
        </div>
    </div>
@endsection
@section('content')

<div class="container">
    <div class="row">
        <div class="col s12 center-align" style="margin-top: 20px">
            <a name="why"><h4>Why hire us?</h4></a>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <div style="width: 20%; float: left; padding-top: 10px; font-size: 120px; line-height: 100px; font-weight: 300; color: #aaaaaa;">1</div>
            <div style="width: 80%; float: left;">
                <h5 class="sbs-red-text">Supreme industry knowledge.</h5>
                <p>Our recruiters have first-hand industry experience. We understand the job duties of the roles you need to fill, and can focus on what makes your position unique to ensure we deliver you the right candidates.</p>
            </div>
        </div>
        <div class="col s12 m6">
            <div style="width: 20%; float: left; padding-top: 10px; font-size: 120px; line-height: 100px; font-weight: 300; color: #aaaaaa;">2</div>
            <div style="width: 80%; float: left;">
                <h5 class="sbs-red-text">The network.</h5>
                <p>We have a combined 20 years' experience in sports business and have relationships with more than 200 teams and properties across all leagues. When it comes to providing you a quality candidate list, we’re confident we have the network necessary to deliver superior results.</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <div style="width: 20%; float: left; padding-top: 10px; font-size: 120px; line-height: 100px; font-weight: 300; color: #aaaaaa;">3</div>
            <div style="width: 80%; float: left;">
                <h5 class="sbs-red-text">Our flexible fee structure.</h5>
                <p>Every recruiting search is different and the resources needed will vary depending on the caliber of the role. We offer different recruiting solutions and believe we deliver the best combination of quality, quantity, and speed for your price.</p>
            </div>
        </div>
        <div class="col s12 m6">
            <div style="width: 20%; float: left; padding-top: 10px; font-size: 120px; line-height: 100px; font-weight: 300; color: #aaaaaa;">4</div>
            <div style="width: 80%; float: left;">
                <h5 class="sbs-red-text">Discretion.</h5>
                <p>In some cases you may not want anyone to know you’ve partnered with a search firm. If discretion is important to you, we have the right networks to compile your candidate list quickly while operating behind the scenes.</p>
            </div>
        </div>
    </div>
    <div class="row white-text" id="areas-of-expertise">
        <div class="col s12" style="background-image: url('/images/training-consulting/recruiting.jpg'); background-size: cover;">
            <h4 class="center-align" style="margin-top: 30px;">Recruiting experience in the following departments</h4>
            <div class="row" style="margin: 0 50px;">
                <div class="col s6">
                    <ul class="bullets">
                        <li>Ticket Sales & Business Development</li>
                        <li>Ticket Operations and Strategy</li>
                        <li>Entry Level Sales & Seasonal Roles</li>
                        <li>Account Management, Service & Retention</li>
                        <li>Premium Sales, Service and Hospitality</li>
                        <li>Sales & Service Leadership</li>
                    </ul>
                </div>
                <div class="col s6">
                    <ul class="bullets">
                        <li>Business Intelligence & Analytics</li>
                        <li>Marketing & Social Media</li>
                        <li>Sponsorship & Activation</li>
                        <li>Marketing Partnership Leadership</li>
                        <li>Executive Team and the C-Suite</li>
                    </ul>
                </div>
            </div>
            <div class="row" style="margin: 20px auto;">
                <div class="col s12 center-align">
                    <a href="/contact" class="btn btn-large white-outline">Book recruiting</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row center-align" style="margin-top: 40px; margin-bottom: 30px;">
        <div class="col s12">
            <h3 id="recruiting-clients">Recruiting clients & testimonials</h3>
        </div>
    </div>
    <div class="row center-align clients">
        <div class="col s12">
            <img class="logo" src="/images/recruiting/clients/nba/image5.jpeg" alt="" >
            <img class="logo" src="/images/recruiting/clients/nhl/image16.jpeg" alt="" >
            <img class="logo" src="/images/recruiting/clients/mlb/image14.png" alt="" style="height:100px;">
            <img class="logo" src="/images/recruiting/clients/mls/image21.png" alt="" >
            <img class="logo" src="/images/recruiting/clients/nfl/image6.jpeg" alt="" >
            <img class="logo" src="/images/recruiting/clients/other/image50.png" alt="" >
        </div>
        <div class="col s12">
            <ul class="collapsible">
                <li>
                    <div class="collapsible-header">See more clients<span style="float: right;">+</span></div>
                    <div class="collapsible-body" style="padding:0;">
                        <nav class="nav-clients">
                            <ul class="tabs">
                                <li class="tab"><a class="active" href="#nba">NBA</a></li>
                                <li class="tab"><a href="#nhl">NHL</a></li>
                                <li class="tab"><a href="#mlb">MLB</a></li>
                                <li class="tab"><a href="#mls">MLS</a></li>
                                <li class="tab"><a href="#nfl">NFL</a></li>
                                <li class="tab"><a href="#other">Other</a></li>
                            </ul>
                        </nav>
                        <div id="nba" style="padding:30px;">
                            <img class="logo" src="/images/recruiting/clients/nba/image1.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nba/image2.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nba/image3.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nba/image4.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nba/image5.jpeg" alt="" >
                        </div>
                        <div id="nhl" style="padding:30px;">
                            <img class="logo" src="/images/recruiting/clients/nhl/image16.jpeg" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nhl/image17.jpeg" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nhl/image18.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nhl/image19.jpeg" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nhl/image20.png" alt="" >
                        </div>
                        <div id="mlb" style="padding:30px;">
                            <img class="logo" src="/images/recruiting/clients/mlb/image11.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/mlb/image12.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/mlb/image13.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/mlb/image14.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/mlb/image15.png" alt="" >
                        </div>
                        <div id="mls" style="padding:30px;">
                            <img class="logo" src="/images/recruiting/clients/mls/image21.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/mls/image22.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/mls/image23.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/mls/image24.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/mls/image25.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/mls/image26.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/mls/image27.png" alt="" >
                        </div>
                        <div id="nfl" style="padding:30px;">
                            <img class="logo" src="/images/recruiting/clients/nfl/image6.jpeg" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nfl/image7.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nfl/image8.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nfl/image9.jpeg" alt="" >
                            <img class="logo" src="/images/recruiting/clients/nfl/image10.jpeg" alt="" >
                        </div>
                        <div id="other" style="padding:30px;">
                            <img class="logo" src="/images/recruiting/clients/other/image28.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image29.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image30.gif" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image31.jpeg" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image32.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image33.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image34.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image35.jpeg" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image36.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image37.jpeg" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image38.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image39.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image40.jpeg" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image41.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image42.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image43.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image44.jpeg" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image45.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image46.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image47.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image48.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image49.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image50.png" alt="" >
                            <img class="logo" src="/images/recruiting/clients/other/image51.png" alt="" >
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <div class="row" style="padding: 30px 0;">
        <div class="col s12">
            <div class="carousel testimonial recruiting carousel-slider center" data-indicators="true">
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/recruiting/testimonials/angels-baseball.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Working with SBS to fill a Premium Sales AE position was quick and easy. They provided a number of qualified applicants to interview, many we wouldn’t have reached through traditional job postings. The process was simple, and we filled the position within 30 days. Thank you to the SBS team!</p>
                                <p class="heavy">
                                    Jim Panetta<br/>
                                    Sr. Director of Ticket Sales & Service<br/>
                                    Angels Baseball
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/recruiting/testimonials/Minnesota-United-FC-MLS.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Jason and the SBS team have been a pleasure to work with on multiple searches. They have the network to be able to help find quality candidates at all levels for our club and we are very happy with the candidates they’ve helped us find. We will be working with them again in the future.</p>
                                <p class="heavy">
                                    Sean Sittnick<br/>
                                    Vice President, Ticket Sales<br/>
                                    Minnesota United FC
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/recruiting/testimonials/nascar.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>It was a pleasure working Jason and the entire SBS team. Their professionalism and expertise far exceeded our expectations. Our Training and Hiring event was extremely successful and we are already exploring additional ways to incorporate SBS into future plans. I highly recommend working with Jason, Josh and their team!!!</p>
                                <p class="heavy">
                                    Tom Canello<br/>
                                    Managing Director of Customer Engagement<br/>
                                    NASCAR
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/recruiting/testimonials/Oilers-Entertainment-Group-SportsBusinessSolutions.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Jason worked with me on hiring a Manager for one of our brands. Right away he and his team took the time to be thorough in understanding not only our need for the position, but the culture of the company. It is always extremely important that we find the right fit and SBS understood this.</p>
                                <p>Not only did they provide us some great candidates, but they were transparent about the challenges that they were having in the market that made it easy for us to understand what was out there and what types of people were coming through our door. Jason allowed me to have as much involvement as I wanted during the process and was always there for check-ins, even just a quick "hello" at the end of the week to make sure everything was going okay. It really felt like we were all working as a team, and I would absolutely use this group (Jason, specifically) again.</p>
                                <p class="heavy">
                                    Michelle Carlson<br/>
                                    Former HR Recruiter<br/>
                                    Oilers Entertainment Group
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/recruiting/testimonials/chicago-cubs-sports-business-solutions.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Jason has been a great asset in assisting the recruitment for several of our sales positions here with the Cubs. With a thorough process and a strong network, Jason and the Sports Business Solutions team are a joy to work with.</p>
                                <p class="heavy">
                                    Chris Weddige<br/>
                                    Assistant Director, Ticket Sales<br/>
                                    Chicago Cubs
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/recruiting/testimonials/fc-dallas-logo-transparent.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Sports Business Solutions provided us tremendous service while helping to fill the vacant Business Development position on our team. We were not only looking at candidates background and sales experience, but it was important for us to find the right cultural fit for our organization. Jason truly grasp the character of our team and was diligent in providing candidates that fit the bill.</p>
                                <p class="heavy">
                                    Lauren Halsey<br/>
                                    Director, Business Development<br/>
                                    FC Dallas
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/recruiting/testimonials/legends-transparent.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>For months Legends worked closely with Bob Hamer and the team at Sports Business Solutions to assist in identifying and recruiting sales professionals across all levels our organization.  They have been an unbelievably valuable resource as we have continued to grow our business.</p>
                                <p class="heavy">
                                    Mike Behan<br/>
                                    Vice President of Sales<br/>
                                    Legends Sales & Marketing
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
