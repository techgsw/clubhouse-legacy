<!-- /resources/views/question/edit.blade.php -->
@extends('layouts.clubhouse')
@if($context == 'same_here')
    @section('title', 'Mental Health Discussion Board')
@elseif($context == 'sales_vault')
    @section('title', 'Sport Sales Discussion Board')
@endif
@section('content')
<div class="container">
    <div class="row">
        <form action="discussion" method="get">
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
            @if ($context == 'same_here' || Auth::user())
                <a href="discussion/create" class="btn btn-large sbs-red">Ask a question</a>
            @else
                <h4>Want to ask a question?</h4>
                <a href="/register" id="buy-now" class="btn sbs-red">Register for a free account</a>
                <p>Already a member? <a href="/login">Login</a></p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @if (count($questions) > 0)
                @foreach ($questions as $question)
                    <div class="row">
                        <div class="col s12">
                            <a href="discussion/{{ $question->id }}"><h5>Q: {{ $question->title }}</h5></a>
                            <p class="light">On {{ $question->created_at->format('F j, Y g:ia') }}</p>
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
