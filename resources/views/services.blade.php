@extends('layouts.default')
@section('title', 'Services')
@section('hero')
    <div class="row hero bg-image services">
        <div class="col s12">
            <h4 class="header">Services</h4>
            <p>We provide sales training, consulting, and recruiting services to sports teams and properties across North America.</p>
            <a href="/contact" class="btn btn-large sbs-red">Become a client</a>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="service-flex">
        <div class="center-align gray-bg red-hover" style="display: flex; flex-direction: column; justify-content: space-between; flex: 1 1 33%; padding: 20px 30px;">
            <div>
                <h4>Training &amp; Consulting</h4>
                <p>With 100+ sports sales teams and more than 1,000 sellers trained in the last five years we’re now a household name in the sales training and consulting space.</p>
            </div>
            <a href="/training-consulting" class="btn" style="margin-top: 30px;">Learn more</a>
        </div>
        <div class="center-align gray-bg red-hover" style="display: flex; flex-direction: column; justify-content: space-between; flex: 1 1 33%; padding: 20px 30px;">
            <div>
                <h4>Recruiting</h4>
                <p>We’ve made more than 100 placements over the last 4 years, as many as anyone else out there. We can help you find a star, quicker, and for a more affordable rate.</p>
            </div>
            <a href="/recruiting-3" class="btn" style="margin-top: 30px;">Learn more</a>
        </div>
        <div class="center-align gray-bg red-hover" style="display: flex; flex-direction: column; justify-content: space-between; flex: 1 1 33%; padding: 20px 30px;">
            <div>
                <h4><span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup></h4>
                <p>We’ve built an educational content platform filled with industry best practices and career guidance for current and aspiring sports business professionals. Join our community for free and take your game to the next level.</p>
            </div>
            <a href="{{ env('CLUBHOUSE_URL') }}" class="btn" style="margin-top: 30px;">Learn more</a>
        </div>
    </div>
    <div class="row hide-on-med-and-up">
        <div class="col s12 center-align gray-bg red-hover">
            <div>
                <h4>Training &amp; Consulting</h4>
                <p>With 100+ sports sales teams and more than 1,000 sellers trained in the last five years we’re now a household name in the sales training and consulting space.</p>
            </div>
            <a href="/training-consulting" class="btn" style="margin-bottom: 20px;">Learn more</a>
        </div>
        <div class="col s12 center-align gray-bg red-hover">
            <div>
                <h4>Recruiting</h4>
                <p>We’ve made more than 100 placements over the last 4 years, as many as anyone else out there. We can help you find a star, quicker, and for a more affordable rate.</p>
            </div>
            <a href="/recruiting-3" class="btn" style="margin-bottom: 20px;">Learn more</a>
        </div>
        <div class="col s12 center-align gray-bg red-hover">
            <div>
                <h4><span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup></h4>
                <p>We’ve built an educational content platform filled with industry best practices and career guidance for current and aspiring sports business professionals. Join our community for free and take your game to the next level.</p>
            </div>
            <a href="{{ env('CLUBHOUSE_URL') }}" class="btn" style="margin-bottom: 20px;">Learn more</a>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align" style="margin-top: 20px">
            <h4>Why work with us?</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m4 center-align">
            <img class="panel-icon" src="/images/services/custom.png" alt="">
            <h4>Customization</h4>
            <p>We work with our clients to understand their challenges and then customize a solution that’s unique for them. We don’t believe in a one-size-fits-all approach as no two teams are alike.</p>
        </div>
        <div class="col s12 m4 center-align">
            <img class="panel-icon" src="/images/services/industry.png" alt="">
            <h4>Industry experience</h4>
            <p>Your business challenges are unique based on your market, team, league, available resources and staffing levels. It takes industry knowledge to understand those challenges. Because we've sat in your seat, we have that industry experience.</p>
        </div>
        <div class="col s12 m4 center-align">
            <img class="panel-icon" src="/images/services/follow-through.png" alt="">
            <h4>Follow through</h4>
            <p>We don’t believe a client relationship ends after the job is done. Upon becoming our client, we will first complete the job at hand, and will then serve as a resource for you long after.</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m4 offset-m2 center-align">
            <img class="panel-icon" src="/images/services/network.png" alt="">
            <h4>Network</h4>
            <p>We have personal relationships with 300+ sports team organizations and have a combined 30+ years of industry best practices and success stories to share. When you partner with us, you benefit from our best-in-class expertise and network.</p>
        </div>
        <div class="col s12 m4 center-align">
            <img class="panel-icon" src="/images/services/passion.png" alt="">
            <h4>Passion</h4>
            <p>We’re in the business of sharing knowledge in an effort to help others succeed. What drives us are the partners we work with. Our secret is the commitment to you and the passion we bring to each project.</p>
        </div>
    </div>
    <div class="row" style="margin: 40px 0;">
        <div class="col s12 center-align">
            <a href="/contact" class="btn btn-large sbs-red">Become a partner today</a>
        </div>
    </div>
</div>
@endsection
