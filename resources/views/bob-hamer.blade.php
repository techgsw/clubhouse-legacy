@extends('layouts.default')
@section('title', 'Bob Hamer')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 center-align" style="margin-top: 20px;">
            <img src="/images/about/bob.png" alt="" style="width: 80%; max-width: 200px; border-radius: 50%;">
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <h3 style="margin: 0;">Bob Hamer</h3>
            <h5>Founder &amp; President</h5>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <p>Bob Hamer has spent the last 15 years in a variety of sales, sales leadership, training, coaching and leadership development roles. He spent 8+ years working in professional sports. Specifically the NBA, with the Phoenix Suns, most recently as their VP of Sales, leading a staff of 50+ sellers and 5+ additional leaders. His passion is teaching, coaching and developing others so he decided to leave the Suns to start his own consulting business, SBS. Launched in 2014, at SBS Bob and his team do Sales Training, Consulting and Leadership Development for their partners throughout North America. They currently have 150 clients and are predominantly serving the sports business industry, working with the majority of NBA, MLB, NHL, NFL, and MLS clubs.</p>
            <p>To date, Bob has conducted more than 400 sales training sessions and trained over 1,500 salespeople throughout North America. They have recently expanded their business services to the Tech, SaaS, and start-up industries and have already acquired key customers in each segment.</p>
            <p>Bob graduated with his Bachelor's Degree in Business Management from the University of Arizona. Originally from Orange County, CA, he currently resides in Phoenix, AZ with his wife Shannon, son Bryson (3) and daughter Sadie (7 mo.)</p>
        </div>
    </div>
    <div class="row" style="margin-bottom: 40px;">
        <div class="col s12">
            <h3>Areas of Expertise</h3>
            <div style="display: grid;grid-template-columns: 80px auto;">
                <img src="/images/sbs-red-arrow-right.png" style="width:50px;margin-top:12px">
                <h5>Sales training, business development, coaching, sales strategy</h5>
                <img src="/images/sbs-red-arrow-right.png" style="width:50px;margin-top:12px">
                <h5>Marketing, promotion, social media, content, execution</h5>
                <img src="/images/sbs-red-arrow-right.png" style="width:50px;margin-top:12px">
                <h5>Entrepreneurship and business management</h5>
                <img src="/images/sbs-red-arrow-right.png" style="width:50px;margin-top:12px">
                <h5>Hiring, recruiting, onboarding, training, culture building</h5>
            </div>
        </div>
    </div>
</div>
<div class="row center-align" style="margin-bottom: 50px;">
    <a href="/contact" class="btn btn-large sbs-red modal-trigger">Contact Bob now</a>
</div>
@endsection
