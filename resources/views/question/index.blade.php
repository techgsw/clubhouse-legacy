<!-- /resources/views/question/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Question & Answer')
@section('subnav')
    @include('layouts.subnav.sales-center')
@endsection
@section('content')
<div class="row">
    <div class="col s12 center-align">
        <h4>Q&amp;A Forum</h4>
    </div>
</div>
<div class="row">
    <div class="col s12 m8 input-field">
        <input id="search" type="text" name="search">
        <label for="search">Search</label>
    </div>
    <div class="col s12 m4 input-field">
        <a href="/question/create" class="btn sbs-red">Ask a question</a>
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
@endsection
