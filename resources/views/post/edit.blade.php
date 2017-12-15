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
        <div class="col s12 left-align">
            <div class="row" style="margin-bottom: 0;">
                <div class="input-field col s12 m4 l3">
                    <i class="fa fa-tags fa-small prefix" style="font-size: 1.5rem; margin-top: 12px;" aria-hidden="true"></i>
                    <input type="text" id="tag-autocomplete-input" class="tag-autocomplete">
                    <label for="tag-autocomplete-input">Tags</label>
                </div>
                <div class="col s12 m8 l9">
                    <div class="post-tags" style="position: relative; margin-top: 26px;">
                        @foreach ($post->tags as $tag)
                            <span class="flat-button gray small" style="display: inline-block; margin: 2px;">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <form method="post" action="/post/{{$post->title_url}}" enctype="multipart/form-data">
        <div class="row">
            <div class="col s12">
                {{ csrf_field() }}
                <div class="blog-post">
                    <div class="input-field" style="margin-top: 0;">
                        <input class="title" placeholder="Title" id="title" type="text" name="title" value="{{ old('title') ?: $post->title }}" required autofocus>
                    </div>
                    <div class="markdown-editor" style="outline: none;">
                        {!! $body !!}
                    </div>
                    <div class="hidden">
                        <textarea class="markdown-input" name="body" value=""></textarea>
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
