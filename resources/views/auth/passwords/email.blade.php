<!-- TODO What's this for? -->
@extends('layouts.clubhouse')
@section('title')
    Reset Password
@endsection
@section('content')
<div class="container">
    <div class="row" style="padding-top: 100px; padding-bottom: 100px;">
        <div class="col-md-8 col-md-offset-2">
            @if (request()->query->get('migration') == 'true')
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p style="font-size: 14.5px; font-weight: normal;">{{ (request()->query->get('name') ? request()->query->get('name').', welcome' : 'Welcome') }} back to SBS Consulting!</p>
                        <p>Please enter your email below so that we may send you a password reset link.</p>
                    </div>
                </div>
            @endif
            <div class="panel panel-default">
                @if (request()->query->get('migration') != 'true')
                <div class="panel-heading">Reset Password</div>
                @endif
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert card-panel green white-text">
                            @if (session('status') == "passwords.sent")
                                Please check your email for a reset link. If you have an account with us we will email you a link, otherwise please contact <a href="mailto:theclubhouse@generalsports.com">theclubhouse@generalsports.com</a> and we can help you find your account.
                            @else
                                {{ session('status') }}
                            @endif
                        </div>
                    @endif
                    @if ($errors->has('email'))
                        <div class="alert card-panel green white-text">
                            Please check your email for a reset link. If you have an account with us we will email you a link, otherwise please contact <a href="mailto:theclubhouse@generalsports.com">theclubhouse@generalsports.com</a> and we can help you find your account.
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Email Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn sbs-red">
                                    Send Password Reset Link
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
