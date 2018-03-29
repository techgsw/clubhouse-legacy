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
    <form method="post" id="session-create-dropzone" class="dropzone" action="/session" enctype="multipart/form-data">
        <div class="row">
            <div class="col s12 center-align">
                <div class="card grey lighten-4">
                    <div class="card-content" style="padding-top: 5px;">
                        <div class="dropzone-clickable">
                            <h3>Click or drag images here</h3>
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
        <div class="row">
            <div class="col s12">
                {{ csrf_field() }}
                <div class="blog-post">
                    <div class="input-field" style="margin-top: 0;">
                        <input class="title" placeholder="Title" id="title" type="text" name="title" value="{{ old('title') }}" required autofocus>
                    </div>
                    <div class="markdown-editor" style="outline: none;"></div>
                    <div class="hidden">
                        <textarea class="markdown-input" name="body" value=""></textarea>
                    </div>
                </div>
                <div class="input-field" style="margin-top: 40px;">
                    <input type="submit" class="btn sbs-red" value="Submit" />
                </div>
            </div>
        </div>
    </form>
</div>
<div class="hidden progress-gif">
    <img src="/images/progress.gif" style="max-width: 100px;" alt="Loading..." />
</div>
@endsection
