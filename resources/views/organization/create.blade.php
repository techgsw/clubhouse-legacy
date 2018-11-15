<!-- /resources/views/organization/create.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'New Organization')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @include('organization.forms.create')
        </div>
    </div>
</div>
@endsection
