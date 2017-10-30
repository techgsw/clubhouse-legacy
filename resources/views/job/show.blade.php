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
    <div class="row">
        <div class="col s12 m9 offset-m3 job-inquire">
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
        </div>
    </div>
    @if (count($inquiries) > 0)
        @include('components.inquiry-list', ['inquiries' => $inquiries])
    @endif
</div>
@endsection
