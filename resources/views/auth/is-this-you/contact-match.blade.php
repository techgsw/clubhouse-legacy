<!-- /resources/views/auth/register.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Register - Is This You?')
@section('hero')
    <div class="row hero gray" style="padding-top: 30px; padding-bottom: 30px;">
        <div class="col s12">
            <h4 class="header">Is this you?</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <div class="arrow down"></div>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="row center-align">
        <h5>{{$possible_duplicate_contact->first_name}} {{$possible_duplicate_contact->last_name}}</h5>
        <h6>at {{$possible_duplicate_contact->organization}}</h6>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <p>We found a contact in our records that matches your name. If this is you, we can link this to your account to help keep track of your job assignments.</p>
            <p>Please choose an answer below to complete your registration.</p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 center-align">
            <form method="post" action="/register/is-this-you/contact">
                {{ csrf_field() }}
                <input type="hidden" id="register-token" name="register_token" value="{{$register_token}}">
                <div class="row">
                    <div class="col s6">
                        <button name="answer" value="true" type="submit" class="btn sbs-red" style="width:200px;">Yes</button>
                    </div>
                    <div class="col s6">
                        <button name="answer" value="false" type="submit" class="btn sbs-red" style="width:200px;">No</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
