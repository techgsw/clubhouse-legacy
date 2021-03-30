<!-- /resources/views/blog/index.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Blog')
@section('hero')
    <div class="row hero bg-image blog">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/digital-marketing-white.png" />
            <h4 class="header">Sports Industry Blog</h4>
            <p>Best practices, advice and success stories in sports business.</p>
            <p>If you’re interested in contributing to our blog, email us <a href="mailto:clubhouse@sportsbusiness.solutions">here</a>.</p>
        </div>
    </div>
@endsection
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
            <!-- No tag cloud on mobile. Leaving this here in case we want to do something else with this
            <div class="tag-cloud">
                @foreach ($tags as $tag)
                    <a href="{{ $url . "tag=" . urlencode($tag->slug) }}" class="flat-button black" style="display: inline-block; margin: 4px;">{{ $tag->name }}</a>
                @endforeach
            </div>-->
        </div>
    </div>
    <div class="row">
        <div class="col s12 m8 l9 blog-list">
            @if (request('search') || request('tag'))
                <div style="margin: 12px 0; border-radius: 4px; background: #F2F2F2; padding: 10px 14px;">
                    @if (request('tag') && is_null($result_tag))
                        Sorry, we couldn't find any tags named <b>{{request('tag')}}</b>
                        <a href="/blog" style="float: right;">Go Back</a>
                    @else
                        <b>{{ $posts->total() }}</b> result{{ count($posts) > 1 || count($posts) == 0 ? "s" : "" }}
                        @if (request('search'))
                            searching for <b>{{ request('search') }}</b>
                        @endif
                        @if (request('tag'))
                            tagged <b>{{ $result_tag->name }}</b>
                        @endif
                        <a href="/blog" style="float: right;">Clear</a>
                    @endif
                </div>
            @endif
            @if (count($posts) > 0)
                @foreach ($posts as $post)
                    <div class="blog-list-item">
                        <div class="row">
                            <div class="col s12 l6">
                                @if (!is_null($post->images->first()))
                                    <a href="/post/{{ $post->title_url}}" target="_blank" rel="noopener" class="no-underline blog-image-hover">
                                        <img src={{ $post->images->first()->getURL('share') }} />
                                    </a>
                                @endif
                            </div>
                            <div class="col s12 l6">
                                <a href="/post/{{ $post->title_url}}" target="_blank" rel="noopener" class="no-underline blog-list-hover">
                                    <h5 style="margin-top: 0; margin-bottom: 0; font-weight: 600;">{{ $post->title }}</h5>
                                    <p class="small light" style="margin-top: 3px;">By <span style="text-transform: uppercase;">{{(($post->authored_by) ?: $post->user->first_name.' '.$post->user->last_name)}}</span></p>
                                    @php
                                        // TODO I'm sure this could be more elegant.
                                        $parsedown = new Parsedown();
                                        $body = strip_tags($parsedown->text($post->body));
                                        $post_length = strlen($body);
                                        $index = 200;
                                    @endphp
                                    @if ($post_length > $index)
                                        @while (!preg_match('/\s/', $body[$index]) && $post_length > $index)
                                            @php $index++; @endphp
                                        @endwhile
                                        <p class="">{{ substr($body, 0, $index) }}...</p>
                                    @else
                                        <p class="">{{ $body }}</p>
                                    @endif
                                </a>
                                <div class="hide-on-med-and-up" style="height: 10px"><br></div>
                                @foreach($post->tags as $tag)
                                    <a href="{{ $url . "tag=" . urlencode($tag->slug) }}" class="flat-button black small" style="margin:2px;">{{ $tag->name }}</a>
                                @endforeach
                            </div>
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
        <div class="col hide-on-small-and-down m4 l3">
            <!-- Search -->
            <form action="/blog" method="get">
                <div class="input-field">
                    <input id="search" type="text" name="search" value="{{ request('search') }}">
                    <label for="search">Search</label>
                </div>
                <input type="hidden" name="tag" value="{{ request('tag') }}">
            </form>
            <!-- Tags -->
            <div class="tag-cloud">
                @foreach ($tags as $tag)
                    <a href="{{ $url . "tag=" . urlencode($tag->slug) }}" class="flat-button black" style="display: inline-block; margin: 4px;">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
