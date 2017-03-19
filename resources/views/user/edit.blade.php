<!-- /resources/views/user/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Edit User Profile')
@section('content')
<h5 class="header red-text">Edit User Profile</h5>
@include('layouts.components.errors')
<div class="row">
    <div class="col s12">
        @include('forms.user')
    </div>
</div>
@endsection
