<!-- /resources/views/question/edit.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'New Discussion')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <form class="form-horizontal" role="form" method="POST" action="../discussion">
                {{ csrf_field() }}
                <div class="input-field">
                    <input id="title" type="text" class="validate {{ $errors->has('title') ? 'invalid' : '' }}" name="title" required autofocus>
                    <label for="title" data-error="{{ $errors->first('title') }}">Title</label>
                </div>
                <div class="input-field">
                    <textarea id="body" class="materialize-textarea validate {{ $errors->has('body') ? 'invalid' : '' }}" name="body" required></textarea>
                    <label for="body" data-error="{{ $errors->first('body') }}">Body</label>
                </div>
                @include('layouts.components.errors')
                <div class="input-field">
                    @if ($context == 'same_here')
                        <div class="g-recaptcha" style="transform:scale(0.65);-webkit-transform:scale(0.65);transform-origin:0 0;-webkit-transform-origin:0 0; margin-top: 10px;" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    @endif
                    <button type="submit" class="btn sbs-red">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
