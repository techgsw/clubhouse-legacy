<!-- /resources/views/admin/job.blade.php -->
@extends('layouts.admin')
@section('title', 'Job Board')
@section('content')
@can ('create-job')
    <div class="row">
        <div class="col s12 input-field" style="display: flex; flex-flow: row;">
            <a href="/job/create" class="btn sbs-red" style="flex: 0 0 auto;">List a job</a>
            <span style="text-transform: uppercase; flex: 1 0 auto; margin-left: 16px; text-align: center; vertical-align: bottom; display: inline-block; height: 36px; border-radius: 2px; background: #EFEFEF;line-height: 36px; padding: 0 2rem;"><b>{{ $count }}</b> jobs{{ $searching ? " match search" : " total" }}</span>
        </div>
    </div>
@endcan
<div id="job-search-form">
    @include('forms.admin-job-search')
</div>
<div class="row">
    <div class="col s12">
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
