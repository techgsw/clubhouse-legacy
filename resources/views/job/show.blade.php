<!-- /resources/views/job/show.blade.php -->
@extends('layouts.default')
@section('title', "$job->title with $job->organization")
@section('content')
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
        <p class="small">listed on {{ $job->created_at->format('F j, Y g:ia') }}</p>
        @if (!is_null($job->edited_at))
            <p class="small">edited on {{ $job->edited_at->format('F j, Y g:ia') }}</p>
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
@if (count($inquiries) > 0)
    <div class="row">
        @foreach ($inquiries as $inquiry)
            <div class="col s12 m9 offset-m3 job-inquiry">
                <p class="small">Applied for this job on {{ $inquiry->created_at->format('F j, Y g:ia') }}</p>
                <p><a href="{{ Storage::disk('local')->url($inquiry->resume) }}">View resume</a></p>
            </div>
        @endforeach
    </div>
@endif
<div class="row">
    <div class="col s12 m9 offset-m3 job-inquire">
        @can ('create-inquiry', $job)
            <form method="POST" action="/job/{{ $job->id }}/inquire" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="input-field" style="padding-bottom: 10px;">
                    <h5>Apply</h5>
                </div>
                <div class="input-field">
                    <input id="name" type="text" name="name" value="{{ Auth::user()->getName() }}">
                    <label for="name">Name</label>
                </div>
                <div class="input-field">
                    <input id="email" type="text" name="email" value="{{ Auth::user()->email }}">
                    <label for="email">Email Address</label>
                </div>
                <div class="input-field">
                    <input id="phone" type="text" name="phone" value="{{ Auth::user()->phone }}">
                    <label for="phone">Phone number</label>
                </div>
                <div class="file-field input-field">
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
            </form>
        @else
            <div class="input-field">
                <a href="/register" class="btn sbs-red">Join to apply</a>
            </div>
        @endcan
    </div>
</div>
@endsection
