<!-- /resources/views/question/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Edit Question')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <p class="light">Asked on {{ $question->created_at->format('F j, Y g:ia') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form method="POST" action="/question/{{ $question->id }}">
                {{ csrf_field() }}
                <div class="input-field">
                    <input id="title" type="text" name="title" value="{{ $question->title }}" autofocus>
                    <label for="title" data-error="{{ $errors->first('title') }}">Title</label>
                </div>
                <div class="input-field">
                    <textarea id="body" class="materialize-textarea validate {{ $errors->has('body') ? 'invalid' : '' }}" name="body">{{ $question->body }}</textarea>
                    <label for="body" data-error="{{ $errors->first('body') }}">Body</label>
                </div>
                <div class="input-field">
                    <button type="submit" class="btn sbs-red">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
