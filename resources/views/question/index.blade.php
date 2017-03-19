<!-- /resources/views/question/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Question & Answer')
@section('content')
<div class="row">
    <div class="col s12">
        @include('layouts.components.errors')
    </div>
</div>
<div class="row">
    <div class="col s12">
        <h3 class="sbs-red-text">Question &amp; Answer</h3>
    </div>
</div>
<div class="row">
    <div class="col s12">
        <a href="/question/create" class="btn sbs-red">Ask a question</a>
    </div>
</div>
<div class="row">
    <div class="col s12">
        @if (count($questions) > 0)
            @foreach ($questions as $question)
                <div class="row">
                    <div class="col s12">
                        <a href="/question/{{ $question->id }}"><h5>{{ $question->title }}</h5></a>
                        <p class="light">by {{ $question->user->name }} on {{ $question->created_at->format('F j, Y g:ia') }}</p>
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
