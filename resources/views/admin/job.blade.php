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
                @include('components.admin-job-list-item', ['job' => $job])
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
