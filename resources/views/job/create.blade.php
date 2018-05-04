<!-- /resources/views/job/create.blade.php -->
@extends('layouts.default')
@section('title', 'New Job')
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
            @include('job.forms.create')
        </div>
    </div>
</div>
@endsection
