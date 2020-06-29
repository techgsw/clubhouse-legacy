@extends('layouts.clubhouse')
@section('title', $mentor->contact->getName()." | ".$mentor->contact->getTitle())
@section('description', $mentor->description)
@section('url', Request::fullUrl())
@if ($mentor->contact->headshotImage)
@section('image', $mentor->contact->headshotImage->getURL('share'))
@elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
@section('image', $mentor->contact->user->profile->headshotImage->getURL('share'))
@endif
@section('scripts')
    @include('mentor.components.scripts')
@endsection
@section('content')
<div class="container card-content" style="padding-bottom: 40px;">
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
        <div class="col s8 offset-s2 m3 center-align">
            @if ($mentor->contact->headshotImage)
                <img src="{{ $mentor->contact->headshotImage->getURL('medium') }}" style="width: 80%; border-radius: 50%; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" class="responsive-img headshot" />
            @elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
                <img src="{{ $mentor->contact->user->profile->headshotImage->getURL('medium') }}" style="width: 80%; margin-left: 10%; border-radius: 50%; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" class="responsive-img headshot" />
            @endif
            @if ($mentor->contact->organizations()->first())
                @if (!is_null($mentor->contact->organizations()->first()->image))
                    <div class="col s8 offset-s2">
                        <img src="{{ $mentor->contact->organizations()->first()->image->getURL('small') }}" class="responsive-img" style="" />
                    </div>
                @endif
            @endif
        </div>
        <div class="col s12 m4">
            <h4>{{ $mentor->contact->getName() }}</h4>
        </div>
        <div class="col s12 m5 right-align">
            @foreach($mentor->tags as $tag)
                <a href="/mentor?tag={{ urlencode($tag->name) }}" class="flat-button black small" style="margin:2px;">{{ $tag->name }}</a>
            @endforeach
        </div>
        <div class="col s12 m9 mentor-description">
            <h5>{{ $mentor->contact->getTitle() }}</h5>
            <p>{!! nl2br(e($mentor->description)) !!}</p>
            @php
                $timezones = array(
                    'hst' => 'Hawaii (GMT-10:00)',
                    'akdt' => 'Alaska (GMT-09:00)',
                    'pst' => 'Pacific Time (US & Canada) (GMT-08:00)',
                    'azt' => 'Arizona (GMT-07:00)',
                    'mst' => 'Mountain Time (US & Canada) (GMT-07:00)',
                    'cdt' => 'Central Time (US & Canada) (GMT-06:00)',
                    'est' => 'Eastern Time (US & Canada) (GMT-05:00)'
                );
            @endphp
            <p>Preferred meeting times ({{ (($mentor->timezone) ? $timezones[$mentor->timezone] : 'Not specified') }}):</p>
            <ul style="font-weight: 300">
                <li>{{ ucwords($mentor->day_preference_1) }} - {{ ucwords($mentor->time_preference_1) }}</li>
                <li>{{ ucwords($mentor->day_preference_2) }} - {{ ucwords($mentor->time_preference_2) }}</li>
                <li>{{ ucwords($mentor->day_preference_3) }} - {{ ucwords($mentor->time_preference_3) }}</li>
            </ul>
            @if ($mentor->document)
                <p><a target="_blank" href="{{ Storage::disk('local')->url($mentor->document) }}">View mentor description</a></p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12 m9 offset-m3 mentor-inquire">
            @can ('view-clubhouse')
                <a class="small flat-button red mentor-request-trigger" href="#mentor-request-modal" mentor-id="{{ $mentor->id }}" mentor-name="{{ $mentor->contact->getName() }}" mentor-day-preference-1="{{ ucwords($mentor->day_preference_1) }}" mentor-day-preference-2="{{ ucwords($mentor->day_preference_2) }}" mentor-day-preference-3="{{ ucwords($mentor->day_preference_3) }}" mentor-time-preference-1="{{ ucwords($mentor->time_preference_1) }}" mentor-time-preference-2="{{ ucwords($mentor->time_preference_3) }}" mentor-time-preference-3="{{ ucwords($mentor->time_preference_3) }}" mentor-timezone="{{ (($mentor->timezone) ? $timezones[$mentor->timezone] : 'Not specified') }}" style="margin: 2px;"><i class="fa fa-phone"></i> Schedule a call</a>
            @else
                <h5>Want to schedule a call?</h5>
                @if (Auth::guest())
                    <a href="#register-modal" id="buy-now" class="btn sbs-red">Become a Clubhouse Pro</a>
                @else
                    <a href="/pro-membership" id="buy-now" class="btn sbs-red">Become a Clubhouse Pro</a>
                @endif
            @endcan
            @can ('edit-mentor')
                <a href="/contact/{{ $mentor->contact->id }}/mentor" style="margin: 2px;" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
            @endcan
        </div>
    </div>
</div>
@include('mentor.components.request-modal')
@endsection
