<!-- /resources/views/job/show.blade.php -->
@extends('layouts.default')
@section('title', "$job->title with $job->organization")
@section('description', "$job->description")
@section('url', Request::fullUrl())
@section('image', url('/').Storage::disk('local')->url(str_replace('medium', 'share', $job->image_url)))
@section('content')
<div class="container">
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
            <img src={{ Storage::disk('local')->url($job->image_url) }}>
        </div>
        <div class="col s9 job-description">
            <div class="right">
                <!-- Job controls -->
                @can ('close-job', $job)
                    @if (is_null($job->open) || $job->open == false)
                        <p class="small"><a href="/job/{{ $job->id }}/open" class="green-text"><i class="fa fa-check"></i> Open</a></p>
                    @endif
                    @if (is_null($job->open) || $job->open == true)
                        <p class="small"><a href="/job/{{ $job->id }}/close" class="red-text"><i class="fa fa-ban"></i> Close</a></p>
                    @endif
                @endcan
                @can ('edit-job', $job)
                    <p class="small"><a href="/job/{{ $job->id }}/edit" class="blue-text"><i class="fa fa-pencil"></i> Edit</a></p>
                @endcan
            </div>
            <h5>{{ $job->title }}</h5>
            <p><span class="heavy">{{ $job->organization }}</span> in {{ $job->city }}, {{ $job->state }}</p>
            <p>{!! nl2br(e($job->description)) !!}</p>
            @if ($job->document)
                <p><a target="_blank" href="{{ Storage::disk('local')->url($job->document) }}">View job description</a></p>
            @endif
            <p class="small">listed on {{ $job->created_at->format('F j, Y g:ia') }}</p>
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
    @if (count($inquiries) > 0)
        <div class="row" style="margin-bottom: 0;">
            @foreach ($inquiries as $inquiry)
                <div class="col s12 m9 offset-m3 job-inquiry">
                    <div class="row">
                        <div class="col s3 center-align">
                            @if ($inquiry->user->profile->headshot_url)
                                <img src={{ Storage::disk('local')->url($inquiry->user->profile->headshot_url) }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px;" />
                            @else
                                <i class="material-icons large">person</i>
                            @endif
                        </div>
                        <div class="col s9">
                            <p><a href="/user/{{ $inquiry->user->id }}/profile">{{ $inquiry->name}}</a></p>
                            <p class="small">applied on {{ $inquiry->created_at->format('F j, Y') }}</p>
                            <p class="hide-on-small-only"><a href="{{ Storage::disk('local')->url($inquiry->resume) }}">Résumé</a> | <a href="mailto:{{ $inquiry->email}}">{{ $inquiry->email}}</a> | @component('components.phone', [ 'phone'=> $inquiry->phone ]) @endcomponent</p>
                        </div>
                    </div>
                </div>
            @endforeach
            @if ($inquiries->total() > 8)
                <div class="row">
                    <div class="col s12 center-align">
                        {{ $inquiries->links('components.pagination') }}
                    </div>
                </div>
            @endif
        </div>
    @endif
    <div class="row">
        <div class="col s12 m9 offset-m3 job-inquire">
            @can ('create-inquiry', $job)
                @if ($profile_complete)
                    <form method="POST" action="/job/{{ $job->id }}/inquire" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="name" value="{{ Auth::user()->getName() }}" />
                        <input type="hidden" name="email" value="{{ Auth::user()->email }}" />
                        <input type="hidden" name="phone" value="{{ Auth::user()->profile->phone }}" />
                        <h5>Apply for this job</h5>
                        <div class="row">
                            <div class="col s4 m3 center-align">
                                @if (Auth::user()->profile->headshot_url)
                                    <img src={{ Storage::disk('local')->url(Auth::user()->profile->headshot_url) }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px;" />
                                @else
                                    <i class="material-icons large">person</i>
                                @endif
                            </div>
                            <div class="col s8 m9">
                                <div style="margin-top: 16px;"></div>
                                <p style="margin: 6px 0;">{{ Auth::user()->getName() }}</p>
                                <p style="margin: 6px 0;">{{ Auth::user()->email }}</p>
                                <p style="margin: 6px 0;">@component('components.phone', [ 'phone'=> Auth::user()->profile->phone ]) @endcomponent</p>
                                <div>
                                    <input type="checkbox" name="use_profile_resume" id="use_profile_resume" value="1" checked />
                                    <label for="use_profile_resume">Use résumé from profile <a href="{{ Storage::disk('local')->url(Auth::user()->profile->resume_url) }}" target="_blank"><i class="tiny material-icons">open_in_new</i></a></label>
                                </div>
                                <div id="upload-resume" class="file-field input-field hidden">
                                    <div class="btn white black-text">
                                        <span>Upload Resume</span>
                                        <input type="file" name="resume" value="{{ old('resume') }}">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" name="resume_text" value="{{ old('resume_text') }}">
                                    </div>
                                </div>
                                <div class="input-field">
                                    <button class="btn sbs-red" type="submit" name="button">Apply</button>
                                </div>
                                <div class="input-field">
                                    <p class="small italic">Update this information&mdash;including your default résumé&mdash;by visiting <a href="/user/{{ Auth::user()->id }}/edit-profile">your profile</a>.</p>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <a href="/user/{{ Auth::user()->id }}/edit-profile" class="btn sbs-red">Complete your profile to apply</a>
                @endif
            @else
                <div class="input-field">
                    <a href="/register" class="btn sbs-red">Join to apply</a>
                </div>
            @endcan
        </div>
    </div>
</div>
@endsection
