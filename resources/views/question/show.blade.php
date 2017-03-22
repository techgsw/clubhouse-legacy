<!-- /resources/views/question/show.blade.php -->
@extends('layouts.default')
@section('title', $question->title)
@section('content')
<div class="row">
    <div class="col s12">
        @include('layouts.components.errors')
    </div>
</div>
<div class="row">
    <div class="col s12">
        <div class="right">
            <!-- Question controls -->
            @can ('approve-question', $question)
                @if (is_null($question->approved) || $question->approved == false)
                    <p class="small"><a href="/question/{{ $question->id }}/approve" class="green-text"><i class="fa fa-check"></i> Approve</a></p>
                @endif
                @if (is_null($question->approved) || $question->approved == true)
                    <p class="small"><a href="/question/{{ $question->id }}/disapprove" class="red-text"><i class="fa fa-ban"></i> Disapprove</a></p>
                @endif
            @endcan
            @can ('edit-question', $question)
                <p class="small"><a href="/question/{{ $question->id }}/edit" class="blue-text"><i class="fa fa-pencil"></i> Edit</a></p>
            @endcan
        </div>
        <!-- Question -->
        <h5>{{ $question->title }}</h5>
        <p class="light">by {{ $question->user->getName() }} on {{ $question->created_at->format('F j, Y g:ia') }}</p>
        @if (!is_null($question->edited_at))
            <p class="light">edited by {{ $question->user->getName() }} on {{ $question->edited_at->format('F j, Y g:ia') }}</p>
        @endif
        <p>{!! nl2br(e($question->body)) !!}</p>
        @can ('approve-question', $question)
            @if (is_null($question->approved))
                <div class="chip">Not approved</div>
            @elseif ($question->approved == false)
                <div class="chip sbs-red white-text">Disapproved</div>
            @else
                <div class="chip green white-text">Approved</div>
            @endif
        @endcan
    </div>
</div>
<div class="row">
    <div class="col s12">
        <!-- Answers -->
        @if (count($answers) > 0)
            @foreach ($answers as $answer)
                <div class="row answer">
                    <div class="col s1">
                        @if ($answer->approved == true)
                            <p><a href="/answer/{{ $answer->id }}/disapprove" class="red-text"><i class="fa fa-ban"></i></a></p>
                        @else
                            <p><a href="/answer/{{ $answer->id }}/approve" class="green-text"><i class="fa fa-check"></i></a></p>
                        @endif
                        @if ($answer->user_id == Auth::user()->id)
                            <p><a href="/answer/{{ $answer->id }}/edit" class="blue-text"><i class="fa fa-pencil"></i></a></p>
                        @endif
                    </div>
                    <div class="col s11">
                        <p>{!! nl2br(e($answer->answer)) !!}</p>
                        <p class="light">by {{ $answer->user->getName() }} on {{ $answer->created_at->format('F j, Y g:ia') }}</p>
                        @if (!is_null($answer->edited_at))
                            <p class="light">edited by {{ $answer->user->getName() }} on {{ $answer->edited_at->format('F j, Y g:ia') }}</p>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="row answer">
                <div class="col s12">
                    <p class="light">No answers yet. Have an answer to this question? Submit it below!</p>
                </div>
            </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col s12">
        <!-- Answer form -->
        <form method="POST" action="/question/{{ $question->id }}/answer">
            {{ csrf_field() }}
            <h5>Your Answer</h5>
            <textarea class="materialize-textarea" name="answer"></textarea>
            <button class="btn sbs-red" type="submit" name="button">Submit your answer</button>
        </form>
    </div>
</div>
@endsection
