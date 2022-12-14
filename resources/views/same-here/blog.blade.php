@extends('layouts.clubhouse')
@section('title', '#SameHere Blog')
@php
    if (request('search')) {
        $url = "/same-here/blog?search=" . request('search') . "&";
    } else {
        $url = "/same-here/blog?";
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
            <form action="/same-here/blog" method="get" style="display: flex; flex-flow: row;">
                <div class="input-field" style="flex: 1 0 auto;">
                    <input id="search" type="text" name="search" value="{{ request('search') }}">
                    <label for="search">Search</label>
                </div>
                <div class="input-field" style="flex: 0 0 auto;">
                    <button type="submit" name="submit" class="btn sbs-red btn-xs">Go</button>
                </div>
            </form>
            <!-- Tags -->
            <div class="tag-cloud">
                @foreach ($tags as $tag)
                    @if ($tag->name != '#SameHere')
                        <a href="{{ $url . "tag=" . urlencode($tag->slug) }}" class="flat-button black" style="display: inline-block; margin: 4px;">{{ $tag->name }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m8 l9 blog-list">
            @if (request('search') || request('tag'))
                <div style="margin: 12px 0; border-radius: 4px; background: #F2F2F2; padding: 10px 14px;">
                    <b>{{ $posts->total() }}</b> result{{ count($posts) > 1 || count($posts) == 0 ? "s" : "" }}
                    @if (request('search'))
                        searching for <b>{{ request('search') }}</b>
                    @endif
                    @if (request('tag'))
                        tagged <b>{{ $result_tag->name }}</b>
                    @endif
                    <a href="/same-here/blog" style="float: right;">Clear</a>
                </div>
            @endif
            @if (count($posts) > 0)
                @foreach ($posts as $post)
                    <div class="blog-list-item">
                        <div class="row">
                            <div class="col s4 m3">
                                @if (!is_null($post->images->first()))
                                    <a href="/post/{{ $post->title_url}}" class="no-underline">
                                        <img src={{ $post->images->first()->getURL('medium') }} />
                                    </a>
                                @endif
                            </div>
                            <div class="col s8 m9">
                                <h5 style="margin-top: 0; margin-bottom: 0;"><a href="/post/{{ $post->title_url }}" class="no-underline">{{ $post->title }}</a></h5>
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
                                <a href="/post/{{ $post->title_url }}" class="btn sbs-red btn-small"> Read more</a>
                                <div class="hide-on-med-and-up" style="height: 10px"><br></div>
                                @foreach($post->tags as $tag)
                                    @if ($tag->name != '#SameHere')
                                        <a href="{{ $url . "tag=" . urlencode($tag->slug) }}" class="flat-button black small" style="float:right;margin:2px;">{{ $tag->name }}</a>
                                    @endif
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
            <form action="/same-here/blog" method="get">
                <div class="input-field">
                    <input id="search" type="text" name="search" value="{{ request('search') }}">
                    <label for="search">Search</label>
                </div>
                <input type="hidden" name="tag" value="{{ request('tag') }}">
            </form>
            <!-- Tags -->
            <div class="tag-cloud">
                @foreach ($tags as $tag)
                    @if ($tag->name != '#SameHere')
                        <a href="{{ $url . "tag=" . urlencode($tag->slug) }}" class="flat-button black" style="display: inline-block; margin: 4px;">{{ $tag->name }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
