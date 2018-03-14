<!-- /resources/views/post/create.blade.php -->
@extends('layouts.default')
@section('title', "Edit Post | " . $post->title)
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
                    <form id="create-tag" action="/tag" method="post">
                        {{ csrf_field() }}
                        <i class="fa fa-tags fa-small prefix" style="font-size: 1.5rem; margin-top: 12px;" aria-hidden="true"></i>
                        <input type="text" id="tag-autocomplete-input" class="tag-autocomplete">
                        <label for="tag-autocomplete-input">Tags</label>
                    </form>
                </div>
                <div class="col s12 m8 l9">
                    <div class="post-tags" style="position: relative; margin-top: 26px;">
                        @foreach ($post->tags as $tag)
                            <span class="flat-button gray small tag">
                                <button type="button" name="button" class="x" tag-name="{{ $tag->name }}">&times;</button>{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="/post/{{$post->title_url}}" enctype="multipart/form-data">
        <div class="row">
            <div class="col s6">
                @php
                    $image_path = $post->getImagePath($post->images->where('image_order', 1)->first());
                @endphp
                @if ($image_path)
                    <p class="hide-on-med-and-up" style="text-align: center;">
                        <img style="width: 85%; max-height: auto; box-shadow: 2px 2px #F2F2F2;" src={{ Storage::disk('local')->url($image_path) }} />
                    </p>
                    <p class="hide-on-small-only" style="float: left; margin-right: 20px; margin-top: 5px;">
                        <img style="width: auto; max-height: 300px; box-shadow: 2px 2px #F2F2F2;" src={{ Storage::disk('local')->url($image_path) }} />
                    </p>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col s6">
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
                <input type="hidden" id="post-tags-json" name="post_tags_json" value="{{ old('post_tags_json') ?: $post_tags_json }}">
                <div class="blog-post">
                    <div class="input-field" style="margin-top: 0;">
                        <input class="title" placeholder="Title" id="title" type="text" name="title" value="{{ old('title') ?: $post->title }}" required autofocus>
                    </div>
                    <div class="input-field" style="margin-top: 0;">
                        <span class="prefix" style="color: #b3b3b1; position: absolute; width: 1.5rem; font-size: 0.8rem; margin-top: 14px; transition: color .2s;">BY</span>
                        <input class="authored" style="margin-left: 1.5rem; width: calc(100% - 1.5rem); text-transform: uppercase; border-bottom: none; font-size: 0.8em; margin-bottom: 6px;" placeholder="Author (optional)" id="authored-by" type="text" name="authored_by" value="{{ old('authored_by') ?: $post->authored_by }}">
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
