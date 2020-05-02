<!-- /resources/views/answer/edit.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Edit Answer')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <!-- Question -->
            <h5>{{ $answer->question->title }}</h5>
            <p class="light">asked by {{ $answer->question->user->getName() }} on {{ $answer->question->created_at->format('F j, Y g:ia') }}</p>
            @if (!is_null($answer->question->edited_at))
                <p class="light">edited by {{ $answer->question->user->getName() }} on {{ $answer->question->edited_at->format('F j, Y g:ia') }}</p>
            @endif
            <p>{!! nl2br(e($answer->question->body)) !!}</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form method="POST">
                {{ csrf_field() }}
                <div class="input-field">
                    <textarea id="body" class="materialize-textarea validate {{ $errors->has('answer') ? 'invalid' : '' }}" name="answer">{{ $answer->answer }}</textarea>
                    <label for="answer" data-error="{{ $errors->first('answer') }}">Answer</label>
                </div>
                <div class="input-field">
                    <button type="submit" class="btn sbs-red">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
