<!-- /resources/views/user/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Edit User Profile')
@section('content')
<div class="container">
    @include('layouts.components.errors')
    <div class="row">
        <div class="col s12">
            @include('forms.profile')
        </div>
    </div>
</div>
@endsection
