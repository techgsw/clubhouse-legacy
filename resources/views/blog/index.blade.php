<!-- /resources/views/blog/index.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Blog')
@php
    if (request('search')) {
        $url = "/blog?search=" . request('search') . "&";
    } else {
        $url = "/blog?";
    }
@endphp
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12 hide-on-med-and-up">
            <!-- Search -->
            <form action="/blog" method="get" style="display: flex; flex-flow: row;">
                <div class="input-field" style="flex: 1 0 auto;">
                    <input id="search" type="text" name="search" value="{{ request('search') }}">
                    <label for="search">Search</label>
                </div>
                <div class="input-field" style="flex: 0 0 auto;">
                    <button type="submit" name="submit" class="btn sbs-red btn-xs">Go</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        @include('components.page-search', ['base_url' => '/blog'])
    </div>
    <div class="row">
        <div class="col s12 blog-list">
            @if (request('search') || request('tag'))
                @include('components.page-search-found', ['base_url' => '/blog', 'items' => $posts, 'not_found' => $result_tag])
            @endif
            @if (count($posts) > 0)
                @foreach ($posts->chunk(6) as $chunked_posts)
                    <div class="blog-list-item">
                        <div class="row" style="max-height: 0;">
                            @foreach($chunked_posts as $post)
                            <div class="col s12 m6 l4" >
                                @include('components.blog-list-item', ['post' => $post])
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                <div class="row">
                    <div class="col s12 center-align">
                        {{ $posts->appends(request()->all())->links('components.pagination') }}
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
