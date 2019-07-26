<!-- /resources/views/job/show.blade.php -->
@extends('layouts.clubhouse')
@section('title', "$job->title with $job->organization_name")
@section('description', "$job->description")
@section('url', Request::fullUrl())
@if (!is_null($job->image))
@section('image', $job->image->cdn ? $job->image->getURL('share') : url('/').$job->image->getURL('share'))
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
    <div class="row job-show">
        <div class="col s3">
            @if (!is_null($job->image))
                <img src={{ $job->image->getURL('medium') }}>
            @endif
        </div>
        <div class="col s9 job-description">
            <div class="right">
                <!-- Job controls -->
                <p class="small">
                @can ('close-job', $job)
                    @if (is_null($job->open) || $job->open == false)
                        <a href="/job/{{ $job->id }}/open" class="flat-button small green"><i class="fa fa-check"></i> Open</a>
                    @endif
                    @if (is_null($job->open) || $job->open == true)
                        <a href="/job/{{ $job->id }}/close" class="flat-button small red"><i class="fa fa-ban"></i> Close</a>
                    @endif
                @endcan
                @can ('edit-job', $job)
                    <a href="/job/{{ $job->id }}/edit" class="flat-button small blue"><i class="fa fa-pencil"></i> Edit</a>
                @endcan
                </p>
            </div>
            <h5>{{ $job->title }}</h5>
            <p><span class="heavy">{{ $job->organization_name }}</span> in {{ $job->city }}, {{ $job->state }}, {{ $job->country }}</p>
            <p class="small tags">
                @if ($job->isNew())
                    <span class="label blue white-text" style="letter-spacing: 0.6px; font-size: 10px;"><b>NEW</b></span>
                @endif
                @if ($job->featured)
                    <span class="label sbs-red" style="letter-spacing: 0.6px; font-size: 10px;"><b><i class="fa fa-star icon-left" aria-hidden="true"></i>FEATURED</b></span>
                @endif
                @can ('edit-job-recruiting-type', $job)
                    <span class="label {{$job->recruiting_type_code == 'passive' ? 'gray' : 'blue white-text'}} inverse" style="letter-spacing: 0.6px; display: inline;">{{ucwords($job->recruiting_type_code)}}</span>
                @endcan
            </p>
            <div class="margin: 10px 0;">
                <a class="no-underline" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode($job->getURL($absolute=true))?>"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                <a class="no-underline" target="_blank" href="https://twitter.com/intent/tweet?text=<?=urlencode($job->getURL($absolute=true))?>"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                <a class="no-underline" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?=urlencode($job->getURL($absolute=true))?>&title=<?=urlencode($job->title)?>&source=Sports Business Solutions')?>"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                <a class="no-underline" target="_blank" href="mailto:?Subject=<?=$job->title?> | Sports Business Solutions&body=<?=urlencode($job->getURL($absolute=true))?>"><i class="fa fa-envelope-square fa-16x" aria-hidden="true"></i></a>
            </div>
            {!! $description !!}
            @if ($job->document)
                <p><a target="_blank" href="{{ Storage::disk('local')->url($job->document) }}">View job description</a></p>
            @endif
            @can ('close-job', $job)
                @if (is_null($job->open))
                    <div class="chip">Not open</div>
                @elseif ($job->open == false)
                    <div class="chip sbs-red white-text">Closed</div>
                @else
                    <div class="chip green white-text">Open</div>
                @endif
            @endcan
        </div>
    </div>
    @cannot ('edit-job', $job)
    <div class="row">
        <div class="col s12 m9 offset-m3 job-inquire">
            @cannot ('edit-job', $job)
                @can ('create-inquiry', $job)
                    @if ($profile_complete)
                        @include('forms.job-inquiry')
                    @else
                        <a href="/user/{{ Auth::user()->id }}/edit-profile" class="btn sbs-red">Complete your profile to apply</a>
                    @endif
                @else
                    <div class="input-field">
                        <a href="/register" class="btn sbs-red">Join to apply</a>
                    </div>
                @endcan
            @endcannot
        </div>
    </div>
    @endcannot
    @can ('edit-job', $job)
        <div class="row">
            <div class="col s12 m9 offset-m3">
                <form method="get" action="/job/{{ $job->id }}#applications">
                    <select class="hidden submit-on-change" name="step" id="step">
                        <option value="all" {{ (!request('step') || request('step') == 'all') ? "selected" : "" }}>all</option>
                        @foreach ($job_pipeline as $step)
                                @if ($step->id == 1)
                                    <option value="{{$step->id}}" {{ (!request('step') || request('step') == $step->id) ? "selected" : "" }}>Step{{$step->id}}</option>
                                @else
                                    <option value="{{$step->id}}" {{ request('step') == $step->id ? "selected" : "" }}>{{ $step->id }}</option>
                                @endif
                        @endforeach
                    </select>
                    <div class="row">
                    </div>
                    <div class="row">
                        <div class="col s12 m6" style="margin-bottom: 10px;">
                            <button type="button" class="flat-button small {{ (!request('step') || request('step') == 'all') ? "inverse" : "" }} input-control" input-id="step" value="all"><i class="fa fa-times"></i></button>
                            @foreach ($job_pipeline as $step)
                                @php // TODO combine into single gate @endphp
                                @if ($step->id < 3)
                                <button type="button" class="flat-button small {{ request('step') == $step->id ? "inverse" : "" }} input-control" input-id="step" value='{{$step->id}}'>{{$step->name}}</button>
                                @else
                                    @can ('review-inquiry-admin')
                                        <button type="button" class="flat-button small {{ request('step') == $step->id ? "inverse" : "" }} input-control" input-id="step" value='{{$step->id}}'>{{$step->name}}</button>
                                    @endcan
                                @endif
                            @endforeach
                            @cannot ('review-inquiry-admin')
                                <input type="hidden" value="{{ request('filter') }}" name="filter" id="filter" />
                                <button type="button" class="flat-button small {{ (request('filter') == 'positive') ? "inverse" : "" }} input-control" input-id="filter" value="positive"><i class="fa fa-thumbs-up"></i></button>
                                <button type="button" class="flat-button small {{ (request('filter') == 'negative') ? "inverse" : "" }} input-control" input-id="filter" value="negative"><i class="fa fa-thumbs-down"></i></button>
                            @endcannot
                        </div>
                        <div class="col s12 m6 center-align">
                            <select class="submit-on-change browser-default" style="margin-top: 0; height: 2.0rem;" name="sort">
                                <option value="recent" {{ (!request('sort') || request('sort') == 'recent') ? "selected" : "" }}>Most recent</option>
                                <option value="alpha" {{ request('sort') == 'alpha' ? "selected" : "" }}>Alphabetical (A-Z)</option>
                                <option value="alpha-reverse" {{ request('sort') == 'alpha-reverse' ? "selected" : "" }}>Alphabetical (Z-A)</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endcan
    @if (count($contact_applications) > 0 && (Auth::user() && Auth::user()->can('edit-job', $job)))
        <div class="row">
            <div class="col s12 m9 offset-m3 job-inquire">
                <a name="applications">
                    <h5 style="margin-bottom: 0;">Contact Assignments</h5>
                </a>
            </div>
        </div>
        @include('components.inquiry-list', ['inquiries' => $contact_applications, 'contact' => true, 'job_pipeline' => $job_pipeline])
    @endif
    @if (count($inquiries) > 0 && (Auth::user() && Auth::user()->can('edit-job', $job)))
        <div class="row">
            <div class="col s12 m9 offset-m3 job-inquire">
                <a name="applications">
                    <h5 style="margin-bottom: 0;">User Applications</h5>
                </a>
            </div>
        </div>
        @include('components.inquiry-list', ['inquiries' => $inquiries, 'contact' => false])
    @endif
    @if ((count($inquiries) > 0 || count($contact_applications) > 0) && (Auth::user() && Auth::user()->can('edit-job', $job)))
        @include('components.contact-notes-modal')
        @include('components.inquiry-notes-modal')
        @include('components.contact-job-notes-modal')
    @endif
</div>
@component('components.pdf-view-modal')@endcomponent
@can ('edit-job', $job)
@component('components.inquiry-job-contact-negative-modal')@endcomponent
@endcan
@endsection
