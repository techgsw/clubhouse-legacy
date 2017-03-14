<!-- /resources/views/user/profile/view.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<h5 class="header red-text">Profile</h5>
<p>{{ $user->name }}</p>
<p>{{ $user->email }}</p>
@endsection
