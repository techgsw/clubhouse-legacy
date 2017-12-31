<!-- /resources/views/post/create.blade.php -->
@extends('layouts.default')
@section('title', "Edit Session | " . $session->title)
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <form method="post" action="/session/{{$session->id}}" enctype="multipart/form-data">
        <div class="row">
            <div class="col s12">
                <div class="file-field input-field very-small">
                    <div class="btn white black-text">
                        <span>Edit<span class="hide-on-small-only"> Image</span></span>
                        <input type="file" name="image_url" value="{{ old('image_url') }}">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" name="image_url_text" value="{{ old('image_url_text') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                {{ csrf_field() }}
                <div class="blog-post">
                    <div class="input-field" style="margin-top: 0;">
                        <input class="title" placeholder="Title" id="title" type="text" name="title" value="{{ old('title') ?: $session->title }}" required autofocus>
                    </div>
                    <div class="markdown-editor" style="outline: none;">
                        {!! $description !!}
                    </div>
                    <div class="hidden">
                        <textarea class="markdown-input" name="description" value=""></textarea>
                    </div>
                </div>
                <div class="input-field" style="margin-top: 40px;">
                    <button type="submit" class="btn sbs-red">Save changes</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
