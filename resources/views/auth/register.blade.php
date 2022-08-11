<!-- /resources/views/auth/register.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Register')
@section('hero')
    <a name="register"></a>
    <div class="row hero gray" style="padding-top: 30px; padding-bottom 30px;">
        <div class="col s12">
            @if(isset($influencer))
                <h6>You have been invited by {{ $influencerName }} to</h6>
            @endif
            <h4 class="header">Join our <img style="width:75px;vertical-align: middle;margin-top:-10px;" src="/images/CH_logo-compass.png"/> community</h4>
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
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @include('forms.register')
        </div>
    </div>
</div>
@endsection
