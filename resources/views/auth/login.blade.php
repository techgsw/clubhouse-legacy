@extends('layouts.default')
@section('title', 'Log In')
@section('content')
<h5 class="header red-text">Log In</h5>
<div class="row">
    <div class="col s12">
        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <div class="input-field{{ $errors->has('email') ? ' invalid' : '' }}">
                <label for="email">E-Mail Address</label>
                <input id="email" type="email" class="validate" name="email" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <!-- TODO -->
                @endif
            </div>
            <div class="input-field{{ $errors->has('password') ? ' invalid' : '' }}">
                <label for="password">Password</label>
                <input id="password" type="password" class="validate" name="password" required>
                @if ($errors->has('password'))
                    <!-- TODO -->
                @endif
            </div>
            <p>
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                <label for="remember">Remember Me</label>
            </p>
            <div class="input-field">
                <button type="submit" class="btn waves-effect waves-light red">Login</button>
            </div>
            <div class="input-field">
                <a class="btn white red-text" href="{{ route('password.request') }}">Forgot Your Password?</a>
            </div>
        </form>
    </div>
</div>
@endsection
