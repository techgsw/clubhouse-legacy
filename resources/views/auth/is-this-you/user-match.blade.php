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
        @foreach($possible_duplicate_users as $user)
            <h5>{{preg_replace('/(^..)[^@]*(@.*)/', '$1*****$2', $user->email)}}</h5>
        @endforeach
    </div>
    <div class="row">
        <div class="col s12">
            <p>We found one or more accounts that match your name. If none of these are your account, you can complete your registration below.</p>
            <p>If any of these accounts are yours, we recommend you log in with your existing account and update your email address. You can keep your old email as a secondary email address in your profile.</p>
            <p>If you forgot your password to this account, you can <a href="/password/reset">reset your password here</a>. If you no longer have access to this email, you can let us know at <a href="mailto:{{ __('email.info_address') }}">{{ __('email.info_address') }}</a> and we can work with you to get your old account updated.</p>
            <h6 class="center-align">Log into your other account <a href="/login">here</a></h6>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s12 center-align">
            <form method="post" action="/register/is-this-you/user">
                {{ csrf_field() }}
                <input type="hidden" id="register-token" name="register_token" value="{{$register_token}}">
                <button type="submit" class="btn sbs-red">This isn't me, Complete My Registration</button>
            </form>
        </div>
    </div>
</div>
@endsection
