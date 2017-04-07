@extends('layouts.default')
@section('title', 'Services')
@section('hero')
    <div class="row hero bg-image services">
        <div class="col s12">
            <h4 class="header">Services</h4>
            <p>We provide training, consulting and recruiting services for sports teams and career services for sports industry job seekers.</p>
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
                <p>With 25+ sports sales teams and more than 400 sellers trained in the last two years we've quickly become a household name in the sports sales training and consulting space.</p>
            </div>
            <a href="/training-consulting" class="btn" style="margin-top: 30px;">Learn more</a>
        </div>
        <div class="center-align gray-bg red-hover" style="display: flex; flex-direction: column; justify-content: space-between; flex: 1 1 33%; padding: 20px 30px;">
            <div>
                <h4>Recruiting</h4>
                <p>As former hiring managers with sports teams, we know the company organizational charts and job descriptions for your open positions, along with the skills required to excel in those roles.</p>
            </div>
            <a href="/recruiting-3" class="btn" style="margin-top: 30px;">Learn more</a>
        </div>
        <div class="center-align gray-bg red-hover" style="display: flex; flex-direction: column; justify-content: space-between; flex: 1 1 33%; padding: 20px 30px;">
            <div>
                <h4>Career Services</h4>
                <p>With 10 years of sports industry success we not only understand how to get a job in sports, but how to be great and grow your career once you do.</p>
            </div>
            <a href="/career-services" class="btn" style="margin-top: 30px;">Learn more</a>
        </div>
    </div>
    <div class="row hide-on-med-and-up">
        <div class="col s12 center-align gray-bg red-hover">
            <div>
                <h4>Training &amp; Consulting</h4>
                <p>With 25+ sports sales teams and more than 400 sellers trained in the last two years we've quickly become a household name in the sports sales training and consulting space.</p>
            </div>
            <a href="/training-consulting" class="btn" style="margin-bottom: 20px;">Learn more</a>
        </div>
        <div class="col s12 center-align gray-bg red-hover">
            <div>
                <h4>Recruiting</h4>
                <p>As former hiring managers with sports teams, we know the company organizational charts and job descriptions for your open positions, along with the skills required to excel in those roles.</p>
            </div>
            <a href="/recruiting-3" class="btn" style="margin-bottom: 20px;">Learn more</a>
        </div>
        <div class="col s12 center-align gray-bg red-hover">
            <div>
                <h4>Career Services</h4>
                <p>With 10 years of sports industry success we not only understand how to get a job in sports, but how to be great and grow your career once you do.</p>
            </div>
            <a href="/career-services" class="btn" style="margin-bottom: 20px;">Learn more</a>
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
            <p>We have personal relationships with nearly 150 sports teams and have 10 years of industry best practices and success stories to share. When you partner with us, you benefit from our best-in-class expertise.</p>
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
