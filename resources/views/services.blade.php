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
    <div style="display: flex">
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
    <div class="row">
        <div class="col s12 m4 center-align">
            <h4>Customization</h4>
        </div>
        <div class="col s12 m4 center-align">
            <h4>Industry experience</h4>
        </div>
        <div class="col s12 m4 center-align">
            <h4>Follow through</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m4 offset-m2 center-align">
            <h4>Network</h4>
        </div>
        <div class="col s12 m4 center-align">
            <h4>Passion</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <a href="/contact" class="btn btn-large sbs-red">Become a partner today</a>
        </div>
    </div>
</div>
@endsection
