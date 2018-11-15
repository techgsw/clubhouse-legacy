<!-- /resources/views/blog/index.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Blog')
@section('hero')
    <div class="row hero bg-image blog">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/digital-marketing-white.png" />
            <h4 class="header">Sports Industry Blog</h4>
            <p>These blog articles are created for the industry, by the industry. Our hope is you can learn about these topics from some of the best in the business.</p>
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
                    <button type="submit" name="submit" class="flat-button black">Go</button>
                </div>
            </form>
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
                        tagged <b>{{ $tag->name }}</b>
                    @endif
                    <a href="/blog" style="float: right;">Clear</a>
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
                                <p class="small light" style="margin-top: 3px;">By <span style="text-transform: uppercase;"><?=(($post->authored_by) ?: $post->user->first_name.' '.$post->user->last_name)?></span></p>
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
        <div class="col hide-on-small-only m4 l3">
            <!-- Search -->
            <form action="/blog" method="get">
                <div class="input-field">
                    <input id="search" type="text" name="search" value="{{ request('search') }}">
                    <label for="search">Search</label>
                </div>
                <input type="hidden" name="tag" value="{{ request('tag') }}">
            </form>
            <!-- Tags -->
            <!--
            <div class="tag-cloud">
                @foreach ($tags as $tag)
                    <a href="{{ $url . "tag=" . $tag->slug }}" class="flat-button black" style="display: inline-block; margin: 4px;">{{ $tag->name }}</a>
                @endforeach
            </div>
            -->
        </div>
        <div class="col s12 hide-on-med-and-up">
            <!-- Tags -->
            <!--
            <div class="tag-cloud">
                @foreach ($tags as $tag)
                    <a href="{{ $url . "tag=" . $tag->slug }}" class="flat-button black small" style="display: inline-block; margin: 4px;">{{ $tag->name }}</a>
                @endforeach
            </div>
            -->
        </div>
    </div>
</div>
@endsection
