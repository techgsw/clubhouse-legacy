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
</div>
@endsection
