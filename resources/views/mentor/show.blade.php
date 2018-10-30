@extends('layouts.clubhouse')
@section('title', $mentor->contact->getName()." | ".$mentor->contact->getTitle())
@section('description', $mentor->description)
@section('url', Request::fullUrl())
@if ($mentor->contact->headshotImage)
@section('image', $mentor->contact->headshotImage->getURL('share'))
@elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
@section('image', $mentor->contact->user->profile->headshotImage->getURL('share'))
@endif
@section('content')
<div class="container" style="padding-bottom: 40px;">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    <!-- Job -->
    <div class="row mentor-show">
        <div class="col s3">
            @if ($mentor->contact->headshotImage)
                <img src="{{ $mentor->contact->headshotImage->getURL('medium') }}" style="border-radius: 50%; margin-top: 16px; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" />
            @elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
                <img src="{{ $mentor->contact->user->profile->headshotImage->getURL('medium') }}" style="border-radius: 50%; margin-top: 16px; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" />
            @endif
        </div>
        <div class="col s9 mentor-description">
            <h4>{{ $mentor->contact->getName() }}</h4>
            <h5>{{ $mentor->contact->getTitle() }}</h5>
            <p>{!! nl2br(e($mentor->description)) !!}</p>
            @if ($mentor->document)
                <p><a target="_blank" href="{{ Storage::disk('local')->url($mentor->document) }}">View mentor description</a></p>
            @endif
            @if ($mentor->contact->organizations()->first())
                <img src="{{ $mentor->contact->organizations()->first()->image->getURL('medium') }}" class="responsive-img" style="margin-top: -50px; margin-left: -35px; max-width: 200px; max-height: 200px;" />
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m9 offset-m3 mentor-inquire">
            @can ('view-mentor')
                <a class="small flat-button black mentor-request-trigger" href="#mentor-request-modal" mentor-id="{{ $mentor->id }}" mentor-name="{{ $mentor->contact->getName() }}" style="margin: 2px;"><i class="fa fa-handshake-o"></i> Schedule a meeting</a>
            @else
                <a class="small flat-button black" href="/"><i class="fa fa-handshake-o"></i> Schedule a meeting</a>
            @endcan
            @can ('edit-mentor')
                <a href="/contact/{{ $mentor->contact->id }}/mentor" style="margin: 2px;" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
            @endcan
        </div>
    </div>
</div>
@endsection
