<!-- /resources/views/question/edit.blade.php -->
@extends('layouts.default')
@section('title', 'New Question')
@section('content')
<div class="row">
    <div class="col s12">
        @include('layouts.components.errors')
    </div>
</div>
<div class="row">
    <div class="col s12">
        <form class="form-horizontal" role="form" method="POST" action="/question">
            {{ csrf_field() }}
            <div class="input-field">
                <input id="question" type="text" class="validate {{ $errors->has('question') ? 'invalid' : '' }}" name="question" autofocus>
                <label for="question" data-error="{{ $errors->first('question') }}">Question</label>
            </div>
            <div class="input-field">
                <button type="submit" class="btn waves-effect waves-light red">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
