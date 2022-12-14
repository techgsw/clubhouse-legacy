<!-- /resources/views/auth/register.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Register-job')
@section('hero')
    <a name="register-job"></a>
    <div class="row hero gray" style="padding-top: 30px; padding-bottom 30px;">
        <div class="col s12">
            <h4 class="header">Join our community</h4>
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
            @include('forms.register-job')
        </div>
    </div>
</div>
@endsection
