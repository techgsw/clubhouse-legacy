@extends('layouts.clubhouse')
@section('title', 'Log In')
@section('content')
<div class="container">
    <h5 class="header red-text">Log In</h5>
    @if ($errors->has('email'))
        <div class="row">
            <div class="col s12">
                <div class="alert card-panel red lighten-4 red-text text-darken-4">
                    Sorry, your email or password is incorrect.
                </div>
            </div>
        </div>
    @endif
    <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
        <div class="row">
            <div class="col s12">
                @include('layouts.components.errors')
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <p>Not yet a member? <a href="#register-modal">Click here to register!</a></p>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m6">
                {{ csrf_field() }}
                <div class="input-field{{ $errors->has('email') ? ' invalid' : '' }}">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" class="validate" name="email" value="{{ old('email') }}" required autofocus>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="input-field{{ $errors->has('password') ? ' invalid' : '' }}">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="validate" name="password" required>
                </div>
            </div>
        </div>
        <div class="row center" style="margin-bottom: 50px;">
            <div class="col s12 m6">
                <div class="input-field">
                    <button type="submit" class="btn sbs-red">Login</button>
                </div>
            </div>
            <div class="col s12 m6">
                <div class="input-field">
                    <a class="btn white red-text" href="{{ route('password.request') }}">Reset your password</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
