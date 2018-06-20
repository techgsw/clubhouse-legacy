<!-- /resources/views/job/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Edit Job')
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
            @include('job.forms.edit')
        </div>
    </div>
</div>
@endsection
