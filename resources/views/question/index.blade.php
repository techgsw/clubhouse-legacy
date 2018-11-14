<!-- /resources/views/question/edit.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Question & Answer')
@section('content')
<div class="container">
    <div class="row">
        <form action="/question" method="get">
            <div class="col s12 m9 input-field">
                <input id="search" type="text" name="search" value="{{ request('search') }}">
                <label for="search">Search</label>
            </div>
            <div class="col s12 m3 input-field center-align">
                <button type="submit" class="btn sbs-red">Search</button>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            <a href="/question/create" class="btn btn-large sbs-red">Ask a question</a>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @if (count($questions) > 0)
                @foreach ($questions as $question)
                    <div class="row">
                        <div class="col s12">
                            <a href="/question/{{ $question->id }}"><h5>Q: {{ $question->title }}</h5></a>
                            <p class="light">by {{ $question->user->getName() }} on {{ $question->created_at->format('F j, Y g:ia') }}</p>
                            <p>{{ count($question->answers) }} answers</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="light">No questions yet! Ask one using the button above.</p>
            @endif
        </div>
    </div>
</div>
@endsection
