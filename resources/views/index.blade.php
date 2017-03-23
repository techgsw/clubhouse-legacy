@extends('layouts.default')
@section('title', 'Careers in Sports')
@section('hero')
    <div class="row hero bg-image home">
        <div class="col s12 m8 offset-m2">
            <h2 class="header">At Sports Business Solutions, we help people succeed in sports business.</h2>
            <p>We provide Training, Consulting, and Recruiting services for sports teams and provide Career Services for those interested in working in sports.</p>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col s12 center-align">
            <h3 class="heavy">Let's get started</h3>
        </div>
    </div>
    <div class="row hide-on-med-and-up">
        <div class="col s12 center-align">
            <a href="/services" class="btn sbs-red">I'm at a sports team</a>
        </div>
    </div>
    <div class="row hide-on-med-and-up">
        <div class="col s12 center-align">
            <a href="/job" class="btn sbs-red">I'm a job seeker</a>
        </div>
    </div>
    <div class="row hide-on-small-only">
        <div class="col m6 right-align">
            <a href="/services" class="btn btn-large sbs-red">I'm at a sports team</a>
        </div>
        <div class="col m6 left-align">
            <a href="/job" class="btn btn-large sbs-red">I'm a job seeker</a>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <h3>Our Clients Include</h3>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <img src="/images/home/clients.gif" alt="">
        </div>
    </div>
@endsection
