@extends('layouts.default')
@section('title', 'Sports Sales Center')
@section('subnav')
    @include('layouts.subnav.sales-center')
@endsection
@section('hero')
    <div class="row hero bg-image">
        <div class="col s12">
            <h4 class="header">Sports Sales Center</h4>
            <p>A career development platform for current and aspiring sports sales professionals.</p>
        </div>
    </div>
    <div class="row hero gray">
        <div class="col s12">
            <h4 class="header">Join our community</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <div class="arrow down"></div>
        </div>
    </div>
@endsection
@section('content')
<div class="row">
    <div class="col s12">
        @include('forms.user')
    </div>
</div>
@endsection
