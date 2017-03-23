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
    <div class="col s9">
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
        <!-- TODO View Inquiries here? -->
        @can ('create-inquiry', $job)
            <!-- TODO Inquiry form -->
            <form method="POST" action="/job/{{ $job->id }}/inquire">
                {{ csrf_field() }}
                <div class="input-field">
                    <button class="btn sbs-red" type="submit" name="button">Apply for this job</button>
                </div>
            </form>
        @endcan
    </div>
</div>
@endsection
