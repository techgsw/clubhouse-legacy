<!-- /resources/views/user/questions.blade.php -->
@extends('layouts.default')
@section('title', 'Questions')
@section('content')
<div class="container">
    @component('components.user-header', ['user' => $user])
        @can ('view-profile-notes')
            <button type="button" class="view-profile-notes-btn flat-button black" user-id="{{ $user->id }}">{{ $user->noteCount() }} <i class="fa fa-comments"></i></button>
        @endif
        @if ($user->profile->resume_url)
            <a href="{{ Storage::disk('local')->url($user->profile->resume_url) }}" class="flat-button black"><span class="hide-on-small-only">View </span> Resume</a>
        @else
            <a href="#" class="flat-button black disabled">No Resume</a>
        @endif
        @can ('edit-profile', $user)
            <a href="/user/{{ $user->id }}/edit-profile" class="flat-button black">Edit<span class="hide-on-small-only"> Profile</span></a>
        @endcan
    @endcomponent
    <ul class="nav-tabs" style="margin-bottom: 12px;">
        @can ('view-profile-notes')
            <li class="tab"><a href="/contact/{{ $user->contact->id }}">Contact</a></li>
        @endcan
        <li class="tab"><a href="/user/{{ $user->id }}/profile">Profile</a></li>
        <li class="tab"><a href="/user/{{ $user->id }}/jobs">Jobs</a></li>
        <li class="tab"><a class="active" href="/user/{{ $user->id }}/questions">Q&A</a></li>
    </ul>
    <div class="row">
        <div class="col s12">
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
@include('components.inquiry-notes-modal')
@endsection
