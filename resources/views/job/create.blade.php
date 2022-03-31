<!-- /resources/views/job/create.blade.php -->
@extends('layouts.clubhouse')
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
    <div class="row">
        <div class="col s12">
            Having trouble? Email us at <a href="mailto:theclubhouse@generalsports.com">theclubhouse@generalsports.com</a>
        </div>
    </div>
</div>
@component('components.organization-create-modal', ['leagues' => $leagues, 'organization_types' => $organization_types])@endcomponent
@endsection
