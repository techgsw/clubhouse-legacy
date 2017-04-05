@extends('layouts.default')
@section('title', 'Page Not Found')
@section('content')
<div class="container">
    @if (!Auth::check())
        <div class="row">
            <div class="col s12">
                <p>Please login or register for a free account to access this content.</p>
                <a class="btn btn-large sbs-red" href="/login">Login</a>
                <a class="btn btn-large sbs-red" href="/register">Register</a>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col s12">
                <h3 class="header">Sorry!</h3>
                <p>It appears you aren't allowed to access this content.</p>
            </div>
        </div>
    @endif
</div>
@endsection
