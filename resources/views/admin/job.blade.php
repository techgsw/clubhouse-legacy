<!-- /resources/views/admin/job.blade.php -->
@extends('layouts.admin')
@section('title', 'Job Board')
@section('content')
@can ('create-job')
    <div class="row">
        <div class="col s12 input-field">
            <a href="/job/create" class="btn sbs-red">List a job</a>
        </div>
    </div>
@endcan
<div class="row">
    <div class="col s12">
        <h4>Jobs</h4>
        @if (count($jobs) > 0)
            @foreach ($jobs as $job)
                <a href="/job/{{$job->id}}">
                <div class="row">
                    <div class="col s3 m2">
                        <img src={{ Storage::disk('local')->url($job->image_url) }}>
                    </div>
                    <div class="col s9 m10">
                        <h5>{{ $job->title }}</h5>
                        <p><span class="heavy">{{ $job->organization }}</span> in {{ $job->city }}, {{ $job->state }}</p>
                        <p class="small">listed on {{ $job->created_at->format('F j, Y g:ia') }}</p>
                        <p class="small">
                            @can ('close-job', $job)
                                @if (is_null($job->open))
                                    <span class="spaced">Not open</span>
                                @elseif ($job->open == false)
                                    <span class="spaced">Closed</span>
                                @else
                                    <span class="spaced">Open</span>
                                @endif
                            @endcan
                            @can ('close-job', $job)
                                @if (is_null($job->open) || $job->open == false)
                                    <a href="/job/{{ $job->id }}/open" class="spaced green-text"><i class="fa fa-check"></i> Open</a>
                                @endif
                                @if (is_null($job->open) || $job->open == true)
                                    <a href="/job/{{ $job->id }}/close" class="spaced red-text"><i class="fa fa-ban"></i> Close</a>
                                @endif
                            @endcan
                            @can ('edit-job', $job)
                                <a href="/job/{{ $job->id }}/edit" class="spaced blue-text"><i class="fa fa-pencil"></i> Edit</a>
                            @endcan
                        </p>
                    </div>
                </div>
                </a>
            @endforeach
            <div class="row">
                <div class="col s12 center-align">
                    {{ $jobs->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
