<!-- /resources/views/post/create.blade.php -->
@extends('layouts.clubhouse')
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
                    <form id="create-tag" action="/tag" method="post" class="prevent-default">
                        {{ csrf_field() }}
                        <i class="fa fa-tags fa-small prefix" style="font-size: 1.5rem; margin-top: 12px;" aria-hidden="true"></i>
                        <input type="text" id="tag-autocomplete-input" class="tag-autocomplete posts" target-input-id="post-tags-json" target-view-id="post-tags">
                        <label for="tag-autocomplete-input">Tags</label>
                    </form>
                </div>
                <div class="col s12 m8 l9">
                    <div id="post-tags" class="post-tags" style="position: relative; margin-top: 26px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="/post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <h5>Main image:</h5>
        <div class="row">
            <div class="col s6 center-align">
                <div class="file-field input-field very-small">
                    <div class="btn white black-text">
                        <span>Add<span class="hide-on-small-only"> Image</span></span>
                        <input type="file" name="primary_image_url" value="{{ old('primary_image_url') }}">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" name="primary_image_url_text" value="{{ old('primary_image_url_text') }}">
                    </div>
                </div>
                <input type="text" placeholder="Alt" name="primary_image_alt" id="primary_image_alt" value="{{old('primary_image_alt')}}" maxlength="100">
                <input type="text" placeholder="Caption" name="primary_image_caption" id="primary_image_caption" value="{{old('primary_image_caption')}}">
            </div>
        </div>
        <h5>Other images (for the blog body):</h5>
        <div class="blog-images row">
        </div>
        <div class="row">
            <button id="add-blog-image" class="btn flat-button" style="padding-bottom: 35px;">
                <i class="fa fa-plus" style="margin-top:-3px;"></i> Add image
            </button>
        </div>
        <div class="row">
            <div class="col s12">
                <input type="hidden" id="post-tags-json" name="post_tags_json" value="{{ old('post_tags_json') ?: '[]' }}">
                <div class="blog-post">
                    <div class="input-field" style="margin-top: 0;">
                        <input class="title" placeholder="Title" id="title" type="text" name="title" value="{{ old('title') }}" required autofocus>
                    </div>
                    <div class="input-field" style="margin-top: 0;">
                        <span class="prefix" style="color: #b3b3b1; position: absolute; width: 1.5rem; font-size: 0.8rem; margin-top: 14px; transition: color .2s;">BY</span>
                        <input class="authored" style="margin-left: 1.5rem; width: calc(100% - 1.5rem); text-transform: uppercase; border-bottom: none; font-size: 0.8em; margin-bottom: 6px;" placeholder="Author (optional)" id="authored-by" type="text" name="authored_by" value="{{ old('authored_by') }}">
                    </div>
                    <div id="body-editor" class="markdown-editor"></div>
                    <div class="hidden">
                        <textarea class="markdown-input" editor-id="body-editor" name="body" value=""></textarea>
                    </div>
                </div>
                <div class="input-field" style="margin-top: 40px;">
                    <button type="submit" class="btn sbs-red">Post</button>
                </div>
            </div>
        </div>
    </form>
</div>
<div class="blog-images-template hidden">
    @include('post.forms.image', ['i' => null, 'image' => null])
</div>
@endsection
