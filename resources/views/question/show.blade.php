<!-- /resources/views/question/show.blade.php -->
@extends('layouts.clubhouse')
@section('title', $question->title)
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="right">
                <!-- Question controls -->
                @if (Auth::user())
                    @can ('approve-question', $question)
                        @if (is_null($question->approved) || $question->approved == false)
                            <p class="small"><a href="../discussion/{{ $question->id }}/approve" class="green-text"><i class="fa fa-check"></i> Approve</a></p>
                        @endif
                        @if (is_null($question->approved) || $question->approved == true)
                            <p class="small"><a href="../discussion/{{ $question->id }}/disapprove" class="red-text"><i class="fa fa-ban"></i> Disapprove</a></p>
                        @endif
                    @endcan
                    @can ('edit-question', $question)
                        <p class="small"><a href="../discussion/{{ $question->id }}/edit" class="blue-text"><i class="fa fa-pencil"></i> Edit</a></p>
                    @endcan
                @endif
            </div>
            <!-- Question -->
            @if (is_null($question->approved) && (!Auth::user() || Auth::user()->cannot('approve-question')))
            <p class="center-align">Thank you for submitting your discussion! Once we approve your discussion you'll see it on our page.</p>
            @endif
            <h5>{{ $question->title }}</h5>
            <p class="light">{{$question->context == 'sales-vault' ? 'Posted by '.$question->user->first_name.' '.$question->user->last_name : ''}} On {{ $question->created_at->format('F j, Y g:ia') }}</p>
            @if (Auth::user() && Auth::user()->can('approve-question'))
                @if (!is_null($question->edited_at))
                    <p class="light">edited on {{ $question->edited_at->format('F j, Y g:ia') }}</p>
                @endif
            @endif
            <p>{!! nl2br(e($question->body)) !!}</p>
            @can ('approve-question', $question)
                @if (is_null($question->approved))
                    <div class="chip">Not yet approved</div>
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
                    @if ($answer->approved || (Auth::user() && Auth::user()->can('approve-answer')))
                        <div class="row answer">
                            <div class="col s1">
                                @can ('approve-answer')
                                   <p><a href="../discussion/answer/{{ $answer->id }}/disapprove" class="red-text"><i class="fa fa-ban"></i></a></p>
                                   <p><a href="../discussion/answer/{{ $answer->id }}/approve" class="green-text"><i class="fa fa-check"></i></a></p>
                                @endcan
                                @if (Auth::user())
                                    @if ($answer->user_id == Auth::user()->id)
                                        <p><a href="../discussion/answer/{{ $answer->id }}/edit" class="blue-text"><i class="fa fa-pencil"></i></a></p>
                                    @endif
                                @endif
                            </div>
                            <div class="col s11">
                                <p>{!! nl2br(e($answer->answer)) !!}</p>
                                <p class="light">{{$question->context == 'sales-vault' ? 'Posted by '.$answer->user->first_name.' '.$answer->user->last_name : ''}} On {{ $answer->created_at->format('F j, Y g:ia') }}</p>
                                @if (!is_null($answer->edited_at))
                                    <p class="light">edited on {{ $answer->edited_at->format('F j, Y g:ia') }}</p>
                                @endif
                                @can ('approve-answer')
                                    @if (is_null($answer->approved))
                                        <div class="chip">Not yet approved</div>
                                    @elseif ($answer->approved == false)
                                        <div class="chip sbs-red white-text">Disapproved</div>
                                    @else
                                        <div class="chip green white-text">Approved</div>
                                    @endif
                                @endcan
                            </div>
                        </div>
                    @endif
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
            @if ($context == 'same_here' || Auth::user())
                <form method="POST" action="../discussion/{{ $question->id }}/answer">
                    {{ csrf_field() }}
                    <h5>Your Answer</h5>
                    <textarea class="materialize-textarea" name="answer"></textarea>
                    @include('layouts.components.errors')
                    @if ($context == 'same_here')
                        <div class="g-recaptcha" style="transform:scale(0.65);-webkit-transform:scale(0.65);transform-origin:0 0;-webkit-transform-origin:0 0; margin-top: 10px;" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    @endif
                    <button class="btn sbs-red" type="submit" name="button">Submit your answer</button>
                </form>
            @else
                <div class="row center-align">
                    <h4>Want to answer this question?</h4>
                    <a href="#register-modal" id="buy-now" class="btn sbs-red">Register for a free account</a>
                    <p>Already a member? <a href="/login">Login</a></p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
