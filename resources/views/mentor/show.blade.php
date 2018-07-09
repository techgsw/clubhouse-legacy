<!-- /resources/views/mentor/show.blade.php -->
@extends('layouts.default')
@section('title', $mentor->contact->getName())
@section('content')
<div class="container" style="padding-bottom: 40px;">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    @include('layouts.components.messages')
    <div class="row mentor-show">
        <div class="col s12">
            <div style="float: right; margin-top: 6px;">
                @can ('edit-mentor')
                    <a href="/contact/{{ $mentor->contact_id }}/mentor" class="flat-button blue"><i class="icon-left fa fa-pencil"></i>Edit</a>
                @endcan
            </div>
            <h3>{{ $mentor->contact->getName() }}</h3>
            <p>{{ $mentor->description }}</p>
        </div>
    </div>
</div>
@endsection
