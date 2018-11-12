@extends('layouts.clubhouse')
@section('title', 'Careers in Sports')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <h5>{{ Auth::user()->first_name }},</h5>
            <p>Thank you for becoming a <strong>Clubhouse Pro</strong>! A receipt has been emailed to you with all your purchase details.</p>
            <p>Begin taking advantage of your upgraded membership now!</p>
            <p>Complete your <a href="/user/{{ Auth::user()->id }}/edit-profile">career profile</a>, find a sports industry <a href="/mentor">mentor</a>, join an upcoming <a href="/webinars">webinar</a> or save on one of our <a href="/career-services">career services</a>.</p>
        </div>
    </div>
</div>
@endsection
