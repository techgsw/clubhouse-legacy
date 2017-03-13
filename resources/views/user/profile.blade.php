<!-- /resources/views/user/profile.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<h5 class="header red-text">Profile</h5>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!-- User Profile Form -->
<form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
    {{ csrf_field() }}
    <div class="input-field {{ $errors->has('name') ? 'invalid' : '' }}">
        <label for="name">Name</label>
        <input id="name" type="text" class="validate" name="name" value="{{ old('name') }}" required autofocus>
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
    <div class="input-field {{ $errors->has('email') ? 'invalid' : '' }}">
        <label for="email">E-Mail Address</label>
        <input id="email" type="email" class="validate" name="email" value="{{ old('email') }}" required>
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
    <div class="input-field {{ $errors->has('password') ? 'invalid' : '' }}">
        <label for="password">Password</label>
        <input id="password" type="password" class="validate" name="password" required>
        @if ($errors->has('password'))
            <strong>{{ $errors->first('password') }}</strong>
        @endif
    </div>
    <div class="input-field">
        <label for="password-confirm">Confirm Password</label>
        <input id="password-confirm" type="password" class="validate" name="password_confirmation" required>
    </div>
    <div class="input-field">
        <button type="submit" class="btn waves-effect waves-light red">Register</button>
    </div>
</form>
@endsection
