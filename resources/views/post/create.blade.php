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
                <div class="blog-post">
                    <div class="input-field">
                        <input class="title" placeholder="Title" id="title" type="text" name="title" value="{{ old('title') }}" required autofocus>
                    </div>
                    <div class="editor" style="outline: none;"></div>
                    <div class="hidden">
                        <input class="markdown" type="text" name="body" value="">
                    </div>
                </div>
                <div class="input-field" style="margin-top: 40px;">
                    <button type="submit" class="btn sbs-red">Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="/js/medium-editor.js"></script>
<script src="/js/me-markdown.standalone.min.js"></script>
<script>
    (function () {
        var body = document.querySelector("input[name='body']");
        new MediumEditor(document.querySelector(".editor"), {
            extensions: {
                markdown: new MeMarkdown(function (md) {
                    body.value = md;
                })
            }
        });
    })();
</script>
<style type="text/css" media="screen">
    .blog-post {
        outline: none;
    }
    .blog-post .title {
        font-size: 2.2rem;
        letter-spacing: 0.25px;
        border-bottom: none;
    }
    .blog-post .title:focus {
        border-bottom: none !important;
        box-shadow: none !important;
    }
    .blog-post h2 {
        font-size: 1.6rem;
        font-weight: bold;
        color: rgba(0, 0, 0, 0.87);
    }
    .blog-post h3 {
        font-size: 1.25rem;
        font-weight: bold;
        color: #EB2935;
    }
</style>
@endsection
