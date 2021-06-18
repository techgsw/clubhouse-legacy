@extends('layouts.default')
@section('title', 'Achieve Sales Success')
@section('hero')
    <div class="row hero sbs-hero bg-image home">
        <div class="col s12 m4 offset-m2">
            <h2 class="header" style="max-width:550px;min-width:300px;">We help sales leaders and teams hit their goals and achieve even greater results.</h2>
            <br><br>
            <a href="/training-consulting" class="btn btn-large sbs-red">Learn More</a>
        </div>
    </div>
@endsection
@section('content')
<div class="container center-align" style="margin-top:50px">
    <h5 style="font-weight:600;text-transform: uppercase;">Proud to work with some amazing partners</h5>
    <div class="row center-align clients" style="max-width:1000px;margin-right:auto;margin-left:auto;margin-top:40px">
        <div class="col s12" style="display:flex;align-items:center;justify-content:center;flex-wrap:wrap;">
            <img class="logo" src="/images/clients/hootology.JPG" alt="Hootology" style="height:50px;">
            <img class="logo" src="/images/clients/angels.png" alt="Los Angeles Angels" style="height:90px;">
            <img class="logo" src="/images/clients/classpass.png" alt="ClassPass" style="height:100px;">
            <img class="logo" src="/images/clients/titans.png" alt="Tennessee Titans" style="height:90px;">
            <img class="logo" src="/images/clients/lyra.png" alt="Lyra" style="height:60px;">
            <img class="logo" src="/images/clients/brex.png" alt="Brex" style="height:45px;">
            <img class="logo" src="/images/clients/golden-state-warriors.png" alt="Golden State Warriors" style="height:100px;">
            <img class="logo" src="/images/clients/pluralsight.png" alt="Pluralsight" style="height:70px;">
        </div>
    </div>
    <div class="row center-align">
        <a href="#clients-modal" class="btn btn-large sbs-red modal-trigger">See all of our partners</a>
    </div>
    @include('components.clients-modal')
    <hr style="max-width:500px;border:1px solid #DDD;margin: auto;">
</div>
<div class="container center-align" style="margin:60px auto">
    <h5 style="font-weight:600;text-transform:uppercase;">Our Services</h5>
    <div class="service-flex" style="justify-content:space-around; flex-wrap: wrap;margin-top:50px;">
        <a href="/training-consulting" class="no-underline" style="width:315px;margin-bottom:20px;">
            <div class="center-align gray-bg gray-hover" style="display: flex; align-items: center; flex-direction: column; justify-content: space-around; padding: 20px 30px;height:250px;">
                <h4>Sales Training<br>&amp; Coaching</h4>
                <img src="/images/sbs-red-arrow-right.png" style="width:60px;height:auto;">
            </div>
        </a>
        <a href="/training-consulting" class="no-underline" style="width:315px;margin-bottom:20px;">
            <div class="center-align gray-bg gray-hover" style="display: flex; align-items: center; flex-direction: column; justify-content: space-around; padding: 20px 30px;height:250px;">
                <h4>Leadership Development</h4>
                <img src="/images/sbs-red-arrow-right.png" style="width:60px;height:auto;">
            </div>
        </a>
        <a href="/training-consulting" class="no-underline" style="width:315px;margin-bottom:20px;">
            <div class="center-align gray-bg gray-hover" style="display: flex; align-items: center; flex-direction: column; justify-content: space-around; padding: 20px 30px;height:250px;">
                <h4>Strategic<br>Consulting</h4>
                <img src="/images/sbs-red-arrow-right.png" style="width:60px;height:auto;">
            </div>
        </a>
    </div>
</div>
@endsection
