<!-- /resources/views/admin/user.blade.php -->
@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<div class="row">
    <div class="col s12">
        <h4>Users</h4>
        @if (count($users) > 0)
            @foreach ($users as $user)
                <div class="row">
                    <div class="col s12">
                        <a href="/user/{{ $user->id }}"><h5>{{ $user->getName() }}</h5></a>
                        <p>{{ $user->email }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
