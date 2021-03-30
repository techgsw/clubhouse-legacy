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
                    <form id="create-tag" action="/tag" method="post" class="prevent-default">
                        {{ csrf_field() }}
                        <i class="fa fa-tags fa-small prefix" style="font-size: 1.5rem; margin-top: 12px;" aria-hidden="true"></i>
                        <input type="text" id="tag-autocomplete-input" class="tag-autocomplete" target-input-id="post-tags-json" target-view-id="post-tags">
                        <label for="tag-autocomplete-input">Tags</label>
                    </form>
                </div>
                <div class="col s12 m8 l9">
                    <div id="post-tags" class="post-tags" style="position: relative; margin-top: 26px;">
                        @foreach ($post->tags as $tag)
                            <span class="flat-button gray small tag">
                                <button type="button" name="button" class="x" tag-name="{{ $tag->name }}" target-input-id="post-tags-json">&times;</button>{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form method="post" action="/post/{{$post->title_url}}" enctype="multipart/form-data">
        <h5>Main image:</h5>
        <div class="row">
            <div class="col s6">
                @if ($post->images->count() > 0 && !is_null($post->getPrimaryImage()))
                    <p class="hide-on-med-and-up" style="text-align: center;">
                        <img style="width: 85%; max-height: auto; box-shadow: 2px 2px #F2F2F2;" src={{ $post->getPrimaryImage()->getURL('share') }} />
                    </p>
                    <p class="hide-on-small-only" style="float: left; margin-right: 20px; margin-top: 5px;max-height:250px;">
                        <img style="width: auto; max-height: 250px; box-shadow: 2px 2px #F2F2F2;" src={{ $post->getPrimaryImage()->getURL('share') }} />
                    </p>
                @endif
            </div>
            <div class="col s6">
                <div class="file-field input-field very-small">
                    <div class="btn white black-text">
                        <span>Edit<span class="hide-on-small-only"> Image</span></span>
                        <input type="file" name="primary_image_url" value="{{ old('primary_image_url') }}">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" name="primary_image_url_text" value="{{ old('primary_image_url_text') }}">
                    </div>
                </div>
                <p><i>If possible, use images that are 1120x630 or in a similar ratio.</i></p>
                <input type="text" placeholder="Alt" name="primary_image_alt" id="primary_image_alt" value="{{old('primary_image_alt') ?: (!is_null($post->getPrimaryImage()) ? $post->getPrimaryImage()->pivot->alt : '')}}" maxlength="100">
                <input type="text" placeholder="Caption" name="primary_image_caption" id="primary_image_caption" value="{{old('primary_image_caption') ?: (!is_null($post->getPrimaryImage()) ? $post->getPrimaryImage()->pivot->caption : '')}}">
            </div>
        </div>
        <h5>Other images (for the blog body):</h5>
        <div class="blog-images row">
            @foreach($post->images()->where('is_primary', false)->get() as $i => $image)
                @include('post.forms.image', ['i' => $i, 'image' => $image])
            @endforeach
        </div>
        <div class="row">
            <button id="add-blog-image" class="btn flat-button" style="padding-bottom: 35px;">
                <i class="fa fa-plus" style="margin-top:-3px;"></i> Add image
            </button>
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
<div class="blog-images-template hidden">
    @include('post.forms.image', ['i' => null, 'image' => null])
</div>
@endsection
