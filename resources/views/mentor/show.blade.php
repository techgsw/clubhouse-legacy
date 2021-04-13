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
    @if(!$is_blocked)
        @include('mentor.components.scripts')
    @endif
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
        <div class="col s8 offset-s2 m3 center-align" style="margin-bottom: 30px;">
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
            <div class="hide-on-small-only" style="height:150px;"></div>
        </div>
        <div class="col s12 m9">
            <h4>{{ $mentor->contact->getName() }}
                @if ($mentor->getLinkedInLink())
                    &nbsp;
                    <a class="no-underline" href="{{$mentor->getLinkedInLink()}}">
                        <i class="fa fa-linkedin-square"></i>
                    </a>
                @endif
            </h4>
            <h5>{{ $mentor->contact->title }}</h5>
            <h5>{{ $mentor->contact->organization }}</h5>
        </div>
        <div class="col s12 m9" style="margin-top:10px">
            Specialties: 
            @foreach($mentor->tags as $tag)
                <a href="/mentor?tag={{ urlencode($tag->name) }}" class="flat-button black small" style="margin:2px;">{{ $tag->name }}</a>
            @endforeach
        </div>
        <div class="col s12 m7 mentor-description">
            <p>{!! nl2br(e($mentor->description)) !!}</p>
            @if($mentor->calendly_link)
                <p style="display:flex;align-items:center;">This mentorship call with {{$mentor->contact->first_name}} will be scheduled using&nbsp;<img height="30px" src="/images/clubhouse/calendly_logo.png" alt="Calend.ly" /></p>
            @else
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
            @endif
        </div>
        <div class="col s12 m9 mentor-inquire">
            @can ('view-clubhouse')
                @if ($mentor->calendly_link)
                    @php
                        if ($is_blocked) {
                            $calendly_link = '';
                        } else if ($mentor->isMentorBlockedFromRequests() && !Auth::user()->can('view-admin-dashboard')) {
                            $calendly_link = 'mentor-blocked';
                        } else {
                            $calendly_link = base64_encode($mentor->calendly_link);
                        }
                    @endphp
                    <a class="small flat-button red mentor-request-trigger calendly" href="#mentor-calendly-modal" mentor-id="{{$mentor->id}}" user-name="{{Auth::user()->first_name}} {{Auth::user()->last_name}}" user-email="{{Auth::user()->email}}" calendly-link="{{$calendly_link}}" style="margin: 2px;"><i class="fa fa-phone"></i> Schedule call now</a>
                @else
                    <a class="small flat-button red mentor-request-trigger" href="#mentor-request-modal" mentor-id="{{ $mentor->id }}" mentor-name="{{ $mentor->contact->getName() }}" mentor-day-preference-1="{{ ucwords($mentor->day_preference_1) }}" mentor-day-preference-2="{{ ucwords($mentor->day_preference_2) }}" mentor-day-preference-3="{{ ucwords($mentor->day_preference_3) }}" mentor-time-preference-1="{{ ucwords($mentor->time_preference_1) }}" mentor-time-preference-2="{{ ucwords($mentor->time_preference_3) }}" mentor-time-preference-3="{{ ucwords($mentor->time_preference_3) }}" mentor-timezone="{{ (($mentor->timezone) ? $timezones[$mentor->timezone] : 'Not specified') }}" style="margin: 2px;"><i class="fa fa-phone"></i> Schedule a call</a>
                @endif
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
            @can ('view-clubhouse')
                <br><br><i><b>Note:</b> Clubhouse Pro members can book up to two mentorship calls per week.</i>
            @endcan
        </div>
    </div>
</div>
@include('mentor.components.request-modal')
@endsection
