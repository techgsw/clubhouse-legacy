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
                        <p>Sports Business Solutions was launched as a way to help more people. In just a short time, it’s safe to say they have. The company has grown from an idea in 2014 to a real life business. They have nearly 40 sports team clients across the country in all major leagues and markets. To those clients they provide regular sales training, consulting and recruiting services and through their efforts they have helped more than 450 salespeople and sports industry employees accomplish their goals. Beyond that they’ve hosted multiple hiring events for aspiring sports industry professionals and have helped more than 80 of them get their start in sports.</p>
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
        <div class="col s12 m4 center-align">
            <a href="/bob-hamer" class="no-underline">
                <img src="/images/about/bob.png" alt="" style="width: 80%; max-width: 200px; border-radius: 50%;">
                <h5 class="sbs-red-text">Bob Hamer<span class="about-position">Founder &amp; President</span></h5>
            </a>
        </div>
        <div class="col s12 m4 center-align">
            <a href="/mike-rudner" class="no-underline">
                <img src="/images/about/mike.png" alt="" style="width: 80%; max-width: 200px; border-radius: 50%;">
                <h5 class="sbs-red-text">Mike Rudner<span class="about-position">Vice President,<br/>Business Operations</span></h5>
            </a>
        </div>
        <div class="col s12 m4 center-align">
            <a href="/jason-stein" class="no-underline">
                <img src="/images/about/jason.jpg" alt="" style="width: 80%; max-width: 200px; border-radius: 50%;">
                <h5 class="sbs-red-text">Jason Stein<span class="about-position">Director,<br/>Recruiting</span></h5>
            </a>
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
            <div class="carousel testimonial carousel-slider center" data-indicators="true">
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/about/testimonials/seat-geek.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>I had the pleasure of hiring Bob Hamer and working with him in Phoenix for the better part of seven years. Bob has a sharp eye for revenue generation and creating systems that enhance results. His ability to identify and hire great talent, as well as teaching this talent to succeed, is first class. I consider Bob a trusted advisor and would want him as part of my team.</p>
                                <p class="heavy">
                                    Jeff Ianello<br/>
                                    Executive Vice President, Client Partnerships<br/>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/about/testimonials/usf-bulls.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Bob Hamer has a unique perspective to offer young men and women hoping to work in the sport industry. He has progressed from an entry level sales person to a Vice President responsible for generating millions of dollars in revenue. In his role he has recruited, trained and developed successful professionals and has a real understanding of what it takes to be successful in sport business. His experience, concern, empathy and ability to communicate effectively make him uniquely qualified to provide direction and career advice. I can think of very few people with the credibility and interest in helping young people more than Bob Hamer. He will make a difference in people’s lives.</p>
                                <p class="heavy">
                                    Dr. William (Bill) Sutton<br/>
                                    Professor & Director, Sports Management<br/>
                                    University South Florida
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/about/testimonials/arizona-diamondbacks.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>I’ve had the pleasure of knowing and working with Bob Hamer for the last ten years, in that time he has continued to grow and learn each and every day. Now all those lessons he’s learned while working in sports and traveling to visit teams are ready to be passed onto the next generation of industry leaders. The sports business field is highly competitive, and everyone looking for a start should also be looking for an advantage. I cannot think of a better professional to teach, train, recruit, and help place individuals in sports than Bob. His passion to help others learn, grow, and succeed are second to none. I highly recommend Bob to any individuals or teams. If you work with him, I promise you’ll be ahead of the game from that moment on.</p>
                                <p class="heavy">
                                    Ryan Holmstedt<br/>
                                    Sr. Director, Ticket Sales, Arizona Diamondbacks (MLB)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/about/testimonials/new-jersey-devils.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>Bob is someone who has a vast knowledge of the industry and is a proven professional. His experience helps him directly relate to sales rep in every aspect and makes for an extremely enjoyable training experience. He was very adaptable to our specific culture and was able to tailor his methods to fit the needs of our departments.</p>
                                <p class="heavy">
                                    Will Lamont<br/>
                                    Sr. Manager, Group Events<br/>
                                    New Jersey Devils
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
