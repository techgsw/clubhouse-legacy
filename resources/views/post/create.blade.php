<!-- /resources/views/post/create.blade.php -->
@extends('layouts.default')
@section('title', 'New Post')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form method="post" action="/post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="input-field">
                    <input id="title" type="text" class="validate {{ $errors->has('title') ? 'invalid' : '' }}" name="title" value="{{ old('title') }}" required autofocus>
                    <label for="title" data-error="{{ $errors->first('title') }}">Title</label>
                </div>
                <div class="input-field">
                    <textarea id="body" class="materialize-textarea validate {{ $errors->has('body') ? 'invalid' : '' }}" name="body" required>{{ old('body') }}</textarea>
                    <label for="body" data-error="{{ $errors->first('body') }}">Body</label>
                </div>
                <div class="input-field">
                    <button type="submit" class="btn sbs-red">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
