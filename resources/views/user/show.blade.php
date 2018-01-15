<!-- /resources/views/user/show.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<div class="container">
    @component('components.user-header', ['user' => $user])
        <div class="hide-on-small-only" style="padding-top: 24px;"></div>
        @can ('edit-profile', $user)
            <a href="/user/{{ $user->id }}/profile" class="btn sbs-red"><span class="hide-on-small-only">View </span>Profile</a>
        @endcan
    @endcomponent
    <div class="row">
        <div class="col s12">
            <p class="small hide-on-small-only" style="margin: 4px 0;">Joined {{ $user->created_at->format('F j, Y') }}</p>
            <p class="small hide-on-small-only" style="margin: 4px 0;">Last updated {{ $user->updated_at->format('F j, Y') }}</p>
            @if (is_null($user->profile) || is_null($user->profile->job_seeking_status))
                <p><span class="label blue white-text">NEW</span> Check out your <a href="/user/{{$user->id}}/profile">profile</a>! The more complete it is, the better chance we'll have of helping you make progress in your career.</p>
            @else
                <p>According to your profile, you're currently
                    @if ($user->profile->job_seeking_status == 'unemployed')
                        <b>unemployed and actively seeking a new job</b>.
                    @elseif ($user->profile->job_seeking_status == 'employed_active')
                        <b>employed, but actively seeking a new job</b>.
                    @elseif ($user->profile->job_seeking_status == 'employed_passive')
                        <b>employed and passively seeking a new job</b>.
                    @elseif ($user->profile->job_seeking_status == 'employed_future')
                        <b>employed, but open to future opportunities</b>.
                    @elseif ($user->profile->job_seeking_status == 'employed_not')
                        <b>currently employed in your dream job</b>.
                    @endif
                </p>
                <p>Update this information any time by visiting your <a href="/user/{{$user->id}}/edit-profile">profile</a>.</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Job Applications</h4>
            @if (count($user->inquiries))
                @foreach ($user->inquiries as $inquiry)
                    <div style="margin: 14px 10px 4px 2px; border-bottom: 1px solid #EEE;">
                        <a href="/job/{{ $inquiry->job->id }}">
                            <h6>{{ $inquiry->job->title }}</h6>
                            <p>submitted {{ $inquiry->created_at->format('F j, Y g:ia') }}</p>
                        </a>
                    </div>
                @endforeach
            @else
                <p>When you apply for jobs on the <a href="/job">Job Board</a>, those jobs will appear here.</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Q&amp;A Forum</h4>
            @if (count($user->questions))
                @foreach ($user->questions as $question)
                    <div style="margin: 14px 10px 4px 2px; border-bottom: 1px solid #EEE;">
                        <a href="/question/{{ $question->id }}">
                            <h6>{{ $question->title }}</h6>
                            <p>
                                <span class="heavy spaced">{{ count($question->answers) }} answers</span>
                                <span class="spaced">asked {{ $question->created_at->format('F j, Y g:ia') }}</span>
                            </p>
                        </a>
                    </div>
                @endforeach
            @else
                <p>When you ask questions in the <a href="/question">Q&amp;A Forum</a>, they will appear here.</p>
            @endif
        </div>
    </div>
</div>
@include('components.profile-notes-modal')
@endsection
