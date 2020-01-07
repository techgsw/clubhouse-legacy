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
            <p>Sports Business Solutions was launched in 2014 with a simple mission in mind, to help others achieve success in sports. The company was founded by sports industry professional, Bob Hamer. Originally from Orange County, CA and a graduate of the University of Arizona, Bob started his career in sports at the Phoenix Suns right after graduation in 2006. In just eight years he grew his career at the Suns from an entry level salesperson, to the Vice President of Ticket Sales & Service. He was in a great spot with the Suns and they were good to him, but something was missing, and he felt he owed it to himself to figure it out.</p>
            <ul class="collapsible" data-collapsible="accordion">
                <li>
                    <div class="collapsible-header">Read more<span style="float: right;">+</span></div>
                    <div class="collapsible-body" style="padding-top: 0;">
                        <p>In his down time, he began to think about his job, his life, and his future. Through this exploration he began to realize that his true passions were family, sports, business and helping others succeed. Going forward, he wanted to build something new that would allow him to combine those passions, gain more autonomy and flexibility, and positively impact more careers than just those who worked for him in Phoenix. Bob’s passions in 2014 would become the foundation for which Sports Business Solutions was built on, and they continue to guide the business today.</p>
                        <p>SBS was launched to help more people, and after just five years in business, it’s safe to say they’ve now done that in a big way. The company has grown from a small one-man operation in 2014 to a boutique consulting firm with six team members scattered all over North America. They have more than 135 clients across the US and Canada, representing all major leagues and markets. To those clients they provide regular sales training, consulting and recruiting services. Through their efforts they have directly helped more than 1,000 salespeople develop their skills, they have placed more than 100 candidates in new jobs in sports, and through their educational content platform <a href="{{env('CLUBHOUSE_URL')}}"><span class="sbs-red-text">the</span>Clubhouse</a>, they’ve impacted thousands of current and aspiring sports industry professionals. </p>
                        <p>But more than anything SBS is about people. They’re fueled every day by their passion to build relationships with sports industry professionals and help make a positive impact on them personally and professionally. They are ambitious and driven to continue growing their business, but they are committed to keeping great life balance and operating with high integrity along the way. The company is living proof that with passion, commitment and hard work you can create a successful business out of an idea.</p>
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
            <div class="about-card col s4">
                <a href="/bob-hamer" class="no-underline">
                    <img src="/images/about/bob.png" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5 class="sbs-red-text">Bob Hamer<span class="about-position">Founder &amp; President</span></h5>
                </a>
            </div>
            <div class="about-card col s4">
                <a href="/mike-rudner" class="no-underline">
                    <img src="/images/about/mike.png" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5 class="sbs-red-text">Mike Rudner<span class="about-position">Vice President,<br/>Business Operations</span></h5>
                </a>
            </div>
            <div class="about-card col s4">
                <a href="/jason-stein" class="no-underline">
                    <img src="/images/about/jason.jpg" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5 class="sbs-red-text">Jason Stein<span class="about-position">Vice President,<br/>Recruiting &amp; Development</span></h5>
                </a>
            </div>
        </div>
        <div class="about-cards col s12">
            <div class="about-card col s4">
                <a href="/josh-belkoff" class="no-underline">
                    <img src="/images/about/josh.jpg" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5 class="sbs-red-text">Josh Belkoff<span class="about-position">Sr. Director,<br/>Business Development</span></h5>
                </a>
            </div>
            <div class="about-card col s4">
                <a href="/kevin-klammer" class="no-underline">
                    <img src="/images/about/kevin.jpg" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5 class="sbs-red-text">Kevin Klammer<span class="about-position">Sr. Director,<br/>Training &amp; Development</span></h5>
                </a>
            </div>
            <div class="about-card col s4">
                <img src="/images/about/darren.jpg" style="width: 80%; max-width: 180px; border-radius: 50%;">
                <h5 class="sbs-red-text">Darren Arnold<span class="about-position">Advisor,<br/>Canadian Business Operations</span></h5>
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
                                <p>I worked with and for Bob during my first 6+ years with the Phoenix Suns organization. During that time he established himself as true leader with a sincere passion for helping others succeed. I am fortunate to have aligned myself with Bob at the beginning of my career to see what it truly takes to be successful in this industry. I can confidently say that I wouldn’t be where I am today without Bob’s support and direction.</p>
                                <p class="heavy">
                                    Kyle Pottinger<br/>
                                    SVP, Ticket Sales & Service<br/>
                                    Phoenix Suns
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
                                <p>What really impressed me about SBS was how they connected with each person in the training. The trainers ask for a part of the process the reps specifically want to work on and they make sure it gets covered. Their overall ability to keep the room engaged for a whole day was a testament to their training. We look forward to working with them again in the future! </p>
                                <p class="heavy">
                                    Erik Roberts<br/>
                                    Manager, Group Sales<br />
                                    One World Observatory
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
                                <p>We couldn’t be more thrilled with the sales training we received from Sports Business Solutions. It became immediately clear the first day our trainer spent speaking with our sales team that the time management and outbound marketing skills and strategies he was sharing are just as applicable to the performing arts business as they are to the sports industry. In-person, on-site training of this high caliber is typically beyond our financial means, but SBS worked with us in creating a sales training partnership that allows us to benefit from their immense expertise while staying within our limited budget. </p>
                                <p class="heavy">
                                    Scott Sanger<br/>
                                    Group Sales Manager<br />
                                    The John F. Kennedy Center for the Performing Arts
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item" href="#">
                    <div class="row">
                        <div class="col s12 m4">
                            <img class="logo" src="/images/about/testimonials/denver-nuggets-sports-business-solutions.png" alt="">
                        </div>
                        <div class="col s12 m8 left-align">
                            <div class="testimonial-content">
                                <p>What separates SBS from other agencies is their combination of sports industry experience and recruiting experience.  Some sports executives try to get into recruiting and some recruiters try to get into sports, but SBS marries those two things better than any other group out there. It shows with their attention to detail and quality of candidates they send our way.  We’ll continue to use SBS to help us fill positions for the foreseeable future.</p>
                                <p class="heavy">
                                    Roberto Beltramini<br/>
                                    Vice President, Premium Partnerships, Groups & Inside Sales and Service<br />
                                    New York Jets
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
                                <p>I had the pleasure of hiring Bob Hamer and working with him in Phoenix for the better part of seven years. Bob has a sharp eye for revenue generation and creating systems that enhance results. His ability to identify and hire great talent, as well as teaching this talent to succeed, is first class. I consider Bob a trusted advisor and would want him as part of my team.</p>
                                <p class="heavy">
                                    Jeff Ianello<br/>
                                    Executive Vice President, Client Partnerships<br />
                                    SeatGeek
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
