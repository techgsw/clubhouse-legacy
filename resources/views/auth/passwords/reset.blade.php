@extends('layouts.default')
@section('title')
    Reset Password
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert card-panel green white-text">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->has('email'))
                        <div class="alert card-panel red lighten-4 red-text text-darken-4">
                            @if ($errors->first('email') == "passwords.token")
                                Sorry, the reset link has expired. Please <a href="/password/reset">request another reset password email</a>.
                            @elseif ($errors->first('email') == "passwords.user")
                                Sorry, your email is incorrect
                            @else
                                {{ $errors->first('email') }}
                            @endif
                        </div>
                    @endif
                    @if ($errors->has('password'))
                        <div class="alert card-panel red lighten-4 red-text text-darken-4">
                            @if ($errors->first('password') == 'validation.min.string')
                                Sorry, passwords must be at least 6 characters
                            @elseif ($errors->first('password') == 'validation.confirmed')
                                Please make sure your password and password confirmation match
                            @else
                                {{ $errors->first('validation.confirmed') }}
                            @endif
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn sbs-red">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
