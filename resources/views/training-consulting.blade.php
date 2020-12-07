@extends('layouts.default')
@section('title', 'Training & Consulting')
@section('hero')
    <div class="row hero bg-image training-consulting">
        <div class="col s12">
            <h4 class="header">Training &amp; Consulting</h4>
            <p>Our only focus is helping you and your team succeed.</p>
            <a href="#areas-of-expertise" class="btn btn-large sbs-red">Book Training Now</a>
            <a href="#training-clients" class="btn btn-large sbs-red">Clients & Testimonials</a>
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
                <p>Our trainers are experienced sports industry professionals who have done the job. We gain credibility and trust from sales teams because we can speak their language.</p>
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
    <div class="row">
        <div class="col s12 m6">
            <div style="width: 20%; float: left; padding-top: 10px; font-size: 120px; line-height: 100px; font-weight: 300; color: #aaaaaa;">3</div>
            <div style="width: 80%; float: left;">
                <h5 class="sbs-red-text">We share and evolve.</h5>
                <p>We use the feedback we receive after each session to grow and improve. Our goal is to change with the times. As tactics, techniques and the environment change, we too evolve. Our trainers have a passion to perfect their craft and are constantly looking to learn and share the newest most innovative sales 2.0 best practices.</p>
            </div>
        </div>
        <div class="col s12 m6">
            <div style="width: 20%; float: left; padding-top: 10px; font-size: 120px; line-height: 100px; font-weight: 300; color: #aaaaaa;">4</div>
            <div style="width: 80%; float: left;">
                <h5 class="sbs-red-text">We do it as a team.</h5>
                <p>Our trainers are excited to get involved in the sales process. We continually practice and learn from each other: trainer to rep, rep to trainer, and rep to rep. We go on appointments in the field, and we assist wherever needed to achieve results for our partners and their sales teams.</p>
            </div>
        </div>
    </div>
    <div class="row white-text" id="areas-of-expertise">
        <div class="col s12" style="background-image: url('/images/training-consulting/recruiting.jpg'); background-size: cover;">
            <h5 class="center-align" style="margin-top: 30px;">Areas of expertise &amp; training solutions</h4>
            <div class="row" style="margin: 0 50px;">
                <div class="col s6">
                    <ul class="bullets">
                        <li>Inside Sales &amp; entry level sales rep basic training 101</li>
                        <li>Season ticket &amp; partial plan sales strategies &amp; sales rep training 201</li>
                        <li>Premium seating &amp; business to business (B2B) high yield selling 301</li>
                        <li>Customer service &amp; retention training techniques and strategies</li>
                        <li>Group sales strategies &amp; sales rep training</li>
                    </ul>
                </div>
                <div class="col s6">
                    <ul class="bullets">
                        <li>CRM, data &amp; analytics used to optimize sales team performance</li>
                        <li>Sales team building</li>
                        <li>Ticket operations</li>
                        <li>Leadership development &amp; management training</li>
                        <li>Event &amp; in game selling</li>
                        <li>Marketing &amp; promotional strategies</li>
                    </ul>
                </div>
            </div>
            <div class="row" style="margin: 20px auto;">
                <div class="col s12 center-align">
                    <a href="/contact" class="btn btn-large white-outline">Book training now</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row center-align" style="margin-top: 40px; margin-bottom: 30px;">
        <div class="col s12">
            <h3 id="training-clients">Training and consulting clients & testimonials</h3>
        </div>
    </div>
    <div class="row center-align clients">
        <div class="col s12">
            <img class="logo" src="/images/training-consulting/clients/nba/image19.png" alt="" >
            <img class="logo" src="/images/training-consulting/clients/nhl/image37.png" alt="" >
            <img class="logo" src="/images/training-consulting/clients/mlb/image43.png" alt="" style="height:100px;">
            <img class="logo" src="/images/training-consulting/clients/ncaa/image63.png" alt="" >
            <img class="logo" src="/images/training-consulting/clients/mls/image72.png" alt="" >
            <img class="logo" src="/images/training-consulting/clients/nfl/image80.jpeg" alt="" >
            <img class="logo" src="/images/training-consulting/clients/other/image101.png" alt="" >
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
                                    <li class="tab"><a href="#ncaa">NCAA</a></li>
                                    <li class="tab"><a href="#mls">MLS</a></li>
                                    <li class="tab"><a href="#nfl">NFL</a></li>
                                    <li class="tab"><a href="#other">Other</a></li>
                                </ul>
                        </nav>
                        <div id="nba" style="padding:30px;">
                            <img class="logo" src="/images/training-consulting/clients/nba/image1.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image2.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image3.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image4.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image5.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image6.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image7.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image8.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image9.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image10.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image11.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image12.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image13.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image14.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image15.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image16.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image17.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image18.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image19.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image20.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nba/image21.png" alt="" >
                        </div>
                        <div id="nhl" style="padding:30px;">
                            <img class="logo" src="/images/training-consulting/clients/nhl/image22.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image23.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image24.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image25.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image26.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image27.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image28.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image29.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image30.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image31.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image32.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image33.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image34.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image35.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image36.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image37.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image38.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nhl/image39.png" alt="" >
                        </div>
                        <div id="mlb" style="padding:30px;">
                            <img class="logo" src="/images/training-consulting/clients/mlb/image40.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image41.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image42.gif" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image43.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image44.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image45.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image46.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image47.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image48.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image49.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image50.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image51.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image52.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image53.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image54.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mlb/image55.png" alt="" >
                        </div>
                        <div id="ncaa" style="padding:30px;">
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image56.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image57.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image58.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image59.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image60.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image61.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image62.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image63.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image64.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image65.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/ncaa/image66.png" alt="" >
                        </div>
                        <div id="mls" style="padding:30px;">
                            <img class="logo" src="/images/training-consulting/clients/mls/image67.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mls/image68.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mls/image69.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mls/image70.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mls/image71.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mls/image72.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mls/image73.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mls/image74.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mls/image75.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/mls/image76.png" alt="" >
                        </div>
                        <div id="nfl" style="padding:30px;">
                            <img class="logo" src="/images/training-consulting/clients/nfl/image77.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nfl/image78.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nfl/image79.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nfl/image80.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nfl/image81.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nfl/image82.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nfl/image83.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/nfl/image84.png" alt="" >
                        </div>
                        <div id="other" style="padding:30px;">
                            <img class="logo" src="/images/training-consulting/clients/other/image85.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image86.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image87.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image88.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image89.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image90.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image91.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image92.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image93.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image94.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image95.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image96.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image97.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image98.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image99.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image100.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image101.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image102.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image103.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image104.jpeg" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image105.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image106.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image107.png" alt="" >
                            <img class="logo" src="/images/training-consulting/clients/other/image108.png" alt="" >
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
            <div class="carousel testimonial carousel-slider center" data-indicators="true">
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/training-consulting/testimonials/pittsburgh-penguins.png" alt="" style="height:150px">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>SBS has a great approach that simplifies the sales process. They were perfect for our staff which included both new and tenured staff members. Looking forward to working with Bob and his team again in the future!</p>
                                <p class="heavy">
                                    Chad Slencak<br/>
                                    Vice President of Ticket Sales<br/>
                                    Pittsburgh Penguins<br/>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/training-consulting/testimonials/ohio-state.png" alt="" style="height:150px">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Josh did an excellent job in training our staff! We were really impressed with his ability to tie together his sales background in the industry to the challenges our reps face every day. The tailored approach was extremely helpful, and we would love to have Josh work with our team on an annual basis.</p>
                                <p class="heavy">
                                    Jason Rost<br/>
                                    Director of Ticket Sales<br/>
                                    Ohio State University
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/training-consulting/testimonials/stockton-kings.png" alt="" style="height:175px">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>From the moment Josh stepped foot on our sales floor, he brought passion and energy that spread like wildfire throughout our office. After two full days of some of the most engaging training I’ve ever seen, our team responded with their best sales day of the month closing eight season memberships and four group outings. We can’t wait to see Josh again.</p>
                                <p class="heavy">
                                    Dustin Toms<br/>
                                    Vice President of Business Operations<br/>
                                    Stockton Kings
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/training-consulting/testimonials/portland-timbers.png" alt="" style="height:145px">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>I have sat through many training sessions over the years and truly found the two days we spent with Bob and the SBS Consulting team to be some of the best. He provided some very tangible takeaways and I found those and the real-life examples he shared to be both valuable and impactful.</p>
                                <p class="heavy">
                                    Jason Breiter<br/>
                                    Manager, Group Sales & Hospitality<br/>
                                    Portland Timbers
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/training-consulting/testimonials/florida-state.png" alt="" style="height:145px">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Having Josh and SBS visit and train our Sales & Retention staff before the start of the season was fantastic! Josh brought a ton of energy and was able to keep our reps focused on definitive next steps and renewing/closing fence sitters before kickoff. The follow up webinars are a great touch and we look forward to welcoming back Josh again in the future!</p>
                                <p class="heavy">
                                    Mark Cameron<br/>
                                    Sr. Director of Sales, Service, & Retention<br/>
                                    Florida State University
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/training-consulting/testimonials/dallas-mavericks.png" alt="" style="height:125px">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Bob was great for our team. Him starting with a high-level view and then giving us a good idea of how our product fits in other organizations, and vice-versa- how other organizations and businesses can benefit from us. Then getting into the details with us, walking through real conversations, and working with us on live calls made the training more applicable, and the takeaways stronger.</p>
                                <p class="heavy">
                                    Theo Hodges<br/>
                                    Vice President of Sales<br/>
                                    Dallas Mavericks
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/training-consulting/testimonials/oregon-state.png" alt="" style="height:175px">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>We had a great two days of training with Josh. We have a green staff, and Josh immediately established a safe environment that encouraged participation and question asking. Over the two days, he laid a solid foundation for our team to build upon and flourish. We look forward to working with Josh again in the future.</p>
                                <p class="heavy">
                                    Ashton Miller<br/>
                                    Director of Sales<br/>
                                    Oregon State University
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
