<!-- /resources/views/user/show.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<div class="row">
    <div class="col s12">
        @can ('edit-user', $user)
            <div class="input-field right">
                <a href="/user/{{ $user->id }}/edit" class="btn sbs-red">Edit<span class="hide-on-small-only"> profile</span></a>
            </div>
        @endcan
        <h3 class="header">{{ $user->getName() }}</h3>
        <p class="small">Joined {{ $user->created_at->format('F j, Y g:ia') }}</p>
    </div>
</div>
<div class="row">
    <div class="col s12 m6">
        <p>Email: {{ $user->email }}</p>
        @if ($user->title)
            <p>Title: {{ $user->title }}</p>
        @endif
        @if ($user->organization)
            <p>Organization: {{ $user->organization }}</p>
        @endif
    </div>
    <div class="col s12 m6">
        <p>
          <input type="checkbox" id="receives-newsletter" disabled="disabled" {{ $user->receives_newsletter ? "checked" : "" }} />
          <label for="receives-newsletter">Receives newsletter</label>
        </p>
        <p>
          <input type="checkbox" id="is-sales-professional" disabled="disabled" {{ $user->is_sales_professional ? "checked" : "" }} />
          <label for="is-sales-professional">Sports Sales Professional</label>
        </p>
        <p>
          <input type="checkbox" id="is-interested-in-jobs" disabled="disabled" {{ $user->is_interested_in_jobs ? "checked" : "" }} />
          <label for="is-interested-in-jobs">Interested in Jobs</label>
        </p>
    </div>
</div>
@if (count($user->questions))
    <div class="row">
        <div class="col s12">
            <h4>Q&amp;A Forum</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @foreach ($user->questions as $question)
                <a href="/question/{{ $question->id }}">
                    <h6>{{ $question->title }}</h6>
                    <p>
                        <span class="heavy spaced">{{ count($question->answers) }} answers</span>
                        <span class="spaced">asked {{ $question->created_at->format('F j, Y g:ia') }}</span>
                    </p>
                </p>
            @endforeach
        </div>
    </div>
@endif
@if (count($user->inquiries))
    <div class="row">
        <div class="col s12">
            <h4>Job Inquiries</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @foreach ($user->inquiries as $inquiry)
                <a href="/question/{{ $inquiry->id }}">
                    <h6>{{ $inquiry->job->title }}</h6>
                    <p>
                        <span class="spaced">submitted {{ $inquiry->created_at->format('F j, Y g:ia') }}</span>
                    </p>
                </p>
            @endforeach
        </div>
    </div>
@endif
@endsection
