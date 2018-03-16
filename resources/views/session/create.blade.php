@extends('layouts.default')
@section('title', 'New Session')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <form method="post" class="dropzone" action="/session" enctype="multipart/form-data">
        <div class="row">
            <div class="col s12 center-align">
                <h3 class="left-align">Session</h3>
                <div class="card grey lighten-4">
                    <div class="card-content">
                        <div class="dropzone-clickable">
                            <h3>Click here to upload images</h3>
                        </div>
                        <div class="fallback">
                            <input name="file" type="file" multiple />
                        </div>
                        <div id="dropzone-previews">
                            <div class="dz-preview-flex-container center-align"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<div class="row">
            <div class="col s6 center-align">
                <div class="file-field input-field very-small">
                    <div class="btn white black-text">
                        <span>Add<span class="hide-on-small-only"> Image</span></span>
                        <input type="file" class="hidden" name="image_url" value="{{ old('image_url') }}">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" name="image_url_text" value="{{ old('image_url_text') }}">
                    </div>
                </div>
            </div>
        </div>-->
        <div class="row">
            <div class="col s12">
                {{ csrf_field() }}
                <div class="blog-post">
                    <div class="input-field" style="margin-top: 0;">
                        <input class="title" placeholder="Title" id="title" type="text" name="title" value="{{ old('title') }}" required autofocus>
                    </div>
                    <div class="markdown-editor" style="outline: none;"></div>
                    <div class="hidden">
                        <textarea class="markdown-input" name="description" value=""></textarea>
                    </div>
                </div>
                <div class="input-field" style="margin-top: 40px;">
                    <button type="submit" class="btn sbs-red">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
