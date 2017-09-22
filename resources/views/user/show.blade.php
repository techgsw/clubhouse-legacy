<!-- /resources/views/user/show.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @can ('edit-user', $user)
                <div class="input-field right">
                    <a href="/user/{{ $user->id }}/profile" class="btn sbs-red">Profile</span></a>
                </div>
            @endcan
            <h3 class="header">{{ $user->getName() }}</h3>
            <p class="small">Joined {{ $user->created_at->format('F j, Y g:ia') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Profile</h4>
        </div>
    </div>
    @if (is_null($user->profile->job_seeking_status))
        <div class="row">
            <div class="col s12">
                <p><span class="label blue white-text">NEW</span> Check out your <a href="/user/{{$user->id}}/edit-profile">profile</a>! The more complete it is, the better chance we'll have of helping you make progress in your career.</p>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col s12">
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
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col s12">
            <h4>Q&amp;A Forum</h4>
        </div>
    </div>
    @if (count($user->questions))
        <div class="row">
            <div class="col s12">
                @foreach ($user->questions as $question)
                    <a href="/question/{{ $question->id }}">
                        <h6>{{ $question->title }}</h6>
                        <p>
                            <span class="heavy spaced">{{ count($question->answers) }} answers</span>
                            <span class="spaced">asked {{ $question->created_at->format('F j, Y g:ia') }}</span>
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <div class="row">
            <div class="col s12">
                <p>When you ask questions in the <a href="/question">Q&amp;A Forum</a>, they will appear here.</p>
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col s12">
            <h4>Job Inquiries</h4>
        </div>
    </div>
    @if (count($user->inquiries))
        <div class="row">
            <div class="col s12">
                @foreach ($user->inquiries as $inquiry)
                    <a href="/job/{{ $inquiry->job->id }}">
                        <h6>{{ $inquiry->job->title }}</h6>
                        <p>
                            <span class="spaced">submitted {{ $inquiry->created_at->format('F j, Y g:ia') }}</span>
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    @else
        <div class="row">
            <div class="col s12">
                <p>When you apply for jobs on the <a href="/job">Job Board</a>, those jobs will appear here.</p>
            </div>
        </div>
    @endif
</div>
@endsection
