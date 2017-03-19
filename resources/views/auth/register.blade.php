<!-- /resources/views/auth/register.blade.php -->
@extends('layouts.default')
@section('title', 'Register')
@section('content')
<h5 class="header red-text">Register</h5>
<div class="row">
    <div class="col s12">
        @include('forms.register')
    </div>
</div>
@endsection
