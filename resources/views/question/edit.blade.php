<!-- /resources/views/question/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Edit Question')
@section('content')
<div class="row">
    <div class="col s12">
        @include('layouts.components.errors')
    </div>
</div>
<div class="row">
    <div class="col s12">
        <form method="POST" action="/question/{{ $question->id }}">
            {{ csrf_field() }}
            <div class="input-field {{ $errors->has('name') ? 'invalid' : '' }}">
                <label for="question">Question</label>
                <input id="question" type="text" name="question" value="{{ $question->question }}" required autofocus>
                @if ($errors->has('question'))
                    <p><strong>{{ $errors->first('question') }}</strong></p>
                @endif
            </div>
            <div class="input-field">
                <button type="submit" class="btn waves-effect waves-light red">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
