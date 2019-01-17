@extends('layouts.default')
@section('title', 'About')
@section('hero')
    <div class="row hero bg-image about">
        <div class="col s12">
            <h4 class="header">About us</h4>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <p>Sports Business Solutions was launched in 2014 with a simple mission in mind, to help others achieve success in sports business. But what exactly that looked like was unclear at the time. Truth be told, SBS began as just an idea and its story is still being written today.</p>
            <p>The company was founded by sports business industry professional Bob Hamer. Bob had been working for the Phoenix Suns for just over 8 years. He had risen from an entry level salesperson at the Suns to the Vice President of Ticket Sales and Service. Originally from Southern California and a graduate of the University of Arizona, Bob had strong ties to the West Coast. He loved living in Phoenix, had a great job with the Suns, was financially secure, and he had achieved a good deal of success. On the outside he looked to be living the dream and his future looked all but certain. But was it?</p>
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header">Read more<span style="float: right;">+</span></div>
                    <div class="collapsible-body" style="padding-top: 0;">
                        <p>To this day Bob owes much of his professional success to the Phoenix Suns and the leadership team he worked for. He had an unbelievable experience there but something was missing and he felt he owed it to himself to figure it out. In his down time he began to think about his job, his life, and his future. Through this exploration he began to realize that his true passions in life were family, sports, business and helping other people succeed. He wanted to do something professionally that allowed him to combine them all. These pillars would become the foundation for which Sports Business Solutions was built on, and they continue to guide the business today.</p>
                        <p>Sports Business Solutions was launched as a way to help more people. In just a short time, it’s safe to say they have. The company has grown from an idea in 2014 to a real life business. They now have more than 60 sports team clients across the country in all major leagues and markets. To those clients they provide regular sales training, consulting and recruiting services and through their efforts they have helped more than 600 salespeople and sports industry employees accomplish their goals. Beyond that they’ve hosted multiple hiring events for aspiring sports industry professionals and have helped more than 80 of them get their start in sports.</p>
                        <p>But more than anything SBS is about people. They’re fueled every day by their passion to build relationships with every sports industry professional and help make a positive impact on them personally and professionally. They are ambitious and driven to grow the business but are committed to keeping great balance and operating with high integrity along the way. The company is living proof that with passion, commitment and hard work you can create a successful business out of an idea.</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h3 class="center-align">Meet the team</h3>
        </div>
        <div class="about-cards col s12">
            <div class="about-card">
                <a href="/bob-hamer" class="no-underline">
                    <img src="/images/about/bob.png" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5 class="sbs-red-text">Bob Hamer<span class="about-position">Founder &amp; President</span></h5>
                </a>
            </div>
            <div class="about-card">
                <a href="/mike-rudner" class="no-underline">
                    <img src="/images/about/mike.png" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5 class="sbs-red-text">Mike Rudner<span class="about-position">Vice President,<br/>Business Operations</span></h5>
                </a>
            </div>
            <div class="about-card">
                <a href="/jason-stein" class="no-underline">
                    <img src="/images/about/jason.jpg" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5 class="sbs-red-text">Jason Stein<span class="about-position">Vice President,<br/>Recruiting &amp; Development</span></h5>
                </a>
            </div>
            <div class="about-card">
                <a href="/josh-belkoff" class="no-underline">
                    <img src="/images/about/josh.jpg" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5 class="sbs-red-text">Josh Belkoff<span class="about-position">Sr. Director,<br/>Recruiting &amp; Development</span></h5>
                </a>
            </div>
            <div class="about-card">
                <a href="/adam-vogel" class="no-underline">
                    <img src="/images/about/adam.jpg" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5 class="sbs-red-text">Adam Vogel<span class="about-position">Sr. Director,<br/>Training &amp; Development</span></h5>
                </a>
            </div>
        </div>
    </div>
    <div class="row" style="padding: 20px 0 10px 0;">
        <div class="col s12">
            <h3 class="center-align">What others are saying</h3>
            <p class="center-align">Testimonials from Sports Business Solutions's industry contacts.</p>
        </div>
    </div>
    <div class="row" style="padding-bottom: 20px;">
        <div class="col s12">
            <div class="carousel testimonial about carousel-slider center" data-indicators="true">
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/about/testimonials/texas-rangers-sports-business-solutions.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>I am thankful for the professionalism and partnership with Sports Business Solutions.  We have hosted Bob before and had an excellent experience.  We were looking bring in someone for some additional training before opening out Sales Center for Globe Life Field as well as put a few new representatives through the Sports Business Solutions training who had not experienced it before.  In discussing options, Bob was unavailable during the time frame we needed, so Josh Belkoff was recommended.</p>
                                <p>Anytime someone other than the organizational leader comes in, there can be some worry.  Will the quality be the same?  Will the personal touch be present?  Will the training itself be as valuable?  I can say without a doubt now that from start to finish, Josh is a pro!  As we worked together to develop the training schedule, to the daily debriefs, every aspect of Josh’s presentation was top notch!  Josh is a connector.  He has the experience and expertise to fit into any sales training platform you are seeking.  Thank you Sports Business Solutions for making training valuable and memorable.</p>
                                <p class="heavy">
                                    Nick Richardson<br/>
                                    Manager, Inside Sales<br/>
                                    Texas Rangers 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/about/testimonials/International-Speedway-Corporation-SportsBusinessSolutions.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>It was a pleasure working Jason and the entire SBS team. Their professionalism and expertise far exceeded our expectations. Our Training and Hiring event was extremely successful and we are already exploring additional ways to incorporate SBS into future plans. I highly recommend working with Jason, Adam and Josh!!!</p>
                                <p class="heavy">
                                    Tom Canello<br/>
                                    Managing Director<br />
                                    ISC
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/about/testimonials/university-of-arizona-sports-business-solutions.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Working with Sport Business Solutions has helped prepare our sales team to overcome all obstacles. Not only focusing on the sales process, but also the customer service side of the business was crucial to building lasting relationships with our fan base.  We are very pleased with the direction we are headed after our training with SBS.</p>
                                <p class="heavy">
                                    Chris Celona<br/>
                                    Associate Athletic Director, Ticket Sales & CRM<br />
                                    University of Arizona 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/about/testimonials/Denver-Nuggets-SportsBusinessSolutions.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>We had Bob and Adam of SBS out to Denver to train our staff. I would highly recommend both Bob and Adam to any sports organization looking for sales trainers that are extremely collaborative, and who can customize their sessions to your specific market and needs. Our staff was very engaged, and had some great takeaways they can implement right away.</p>
                                <p class="heavy">
                                    Elliott Crichfield<br/>
                                    Senior Manager of Inside Sales<br />
                                    Denver Nuggets 
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/about/testimonials/one-world-observatory.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>What really impresses me about everyone at Sports Business Solutions is how they connect with each person in on our staff. They asked for a part of the process we specifically want to work on and they make sure it is covered. The overall ability to keep the room engaged for a whole day is a testament to their craft in training. We look forward to working with SBS in the future!</p>
                                <p class="heavy">
                                    Erik Roberts<br/>
                                    Assistant Manager, Group Sales<br />
                                    One World Observatory 
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
