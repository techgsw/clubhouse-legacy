<!-- /resources/views/user/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Edit User Profile')
@section('content')
<h5 class="header red-text">Edit User Profile</h5>
@include('layouts.components.errors')
<div class="row">
    <div class="col s12">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="input-field {{ $errors->has('name') ? 'invalid' : '' }}">
                <label for="name">Name</label>
                <input id="name" type="text" class="validate" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                    <p><strong>{{ $errors->first('name') }}</strong></p>
                @endif
            </div>
            <div class="input-field {{ $errors->has('email') ? 'invalid' : '' }}">
                <label for="email">E-Mail Address</label>
                <input id="email" type="email" class="validate" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <p><strong>{{ $errors->first('email') }}</strong></p>
                @endif
            </div>
            <div class="input-field {{ $errors->has('password') ? 'invalid' : '' }}">
                <label for="password">Password</label>
                <input id="password" type="password" class="validate" name="password" required>
                @if ($errors->has('password'))
                    <p><strong>{{ $errors->first('password') }}</strong></p>
                @endif
            </div>
            <div class="input-field">
                <label for="password-confirm">Confirm Password</label>
                <input id="password-confirm" type="password" class="validate" name="password_confirmation" required>
            </div>
            <div class="input-field">
                <button type="submit" class="btn sbs-red">Register</button>
            </div>
        </form>
    </div>
</div>
@endsection
