<!-- /resources/views/admin/user.blade.php -->
@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<div class="row">
    <div class="col s12 input-field">
        <input id="search" type="text" name="search">
        <label for="search">Search all users</label>
    </div>
</div>
<div class="row">
    <div class="col s12">
        <h4>Users</h4>
        @if (count($users) > 0)
            @foreach ($users as $user)
                <div class="row">
                    <div class="col s12">
                        <a href="/user/{{ $user->id }}"><h5>{{ $user->name }}</h5></a>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
