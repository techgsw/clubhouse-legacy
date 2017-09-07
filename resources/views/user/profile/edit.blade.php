<!-- /resources/views/user/profile/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Edit User Profile')
@section('content')
<div class="container">
    @include('layouts.components.messages')
    @include('layouts.components.errors')
    <div class="row">
        <div class="col s12">
            <h3 class="header">{{ $user->getName() }}</h3>
            <p><i class="material-icons tiny icon-left">email</i> {{ $user->email }}</p>
            <p class="small">Joined {{ $user->created_at->format('F j, Y g:ia') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @include('forms.profile')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form id="edit-profile" method="POST" action="/user/{{$user->id}}/edit-profile" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="input-field">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
