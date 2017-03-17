<!-- /resources/views/question/show.blade.php -->
@extends('layouts.default')
@section('title', $question->question)
@section('content')
<div class="row">
    <div class="col s12">
        @include('layouts.components.errors')
    </div>
</div>
<div class="row">
    <div class="col s12">
        <h5>{{ $question->question }}</h5>
        <p>by {{ $question->user->name }} on {{ $question->created_at->format('F j, Y g:ia') }}</p>
        @if (count($answers) > 0)
        @else
            <p class="light">No answers yet. Have an answer to this question? Submit it below!</p>
        @endif
    </div>
</div>
<div class="row">
    <div class="col s12">
        <form method="POST" action="#">
            <h5>Your Answer</h5>
            <textarea class="materialize-textarea" name="answer"></textarea>
            <button class="btn waves-effect waves-light red" type="submit" name="button">Submit your answer</button>
        </form>
    </div>
</div>
@endsection
