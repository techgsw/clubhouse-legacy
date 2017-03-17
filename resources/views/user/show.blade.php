<!-- /resources/views/user/show.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<h5 class="header red-text">{{ $user->name }}</h5>
<p>{{ $user->email }}</p>
@endsection
