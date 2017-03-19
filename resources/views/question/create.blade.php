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
                <input id="title" type="text" class="validate {{ $errors->has('title') ? 'invalid' : '' }}" name="title" autofocus>
                <label for="title" data-error="{{ $errors->first('title') }}">Title</label>
            </div>
            <div class="input-field">
                <textarea id="body" class="materialize-textarea validate {{ $errors->has('body') ? 'invalid' : '' }}" name="body"></textarea>
                <label for="body" data-error="{{ $errors->first('body') }}">Body</label>
            </div>
            <div class="input-field">
                <button type="submit" class="btn sbs-red">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
