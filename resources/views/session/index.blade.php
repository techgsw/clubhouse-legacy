@extends('layouts.default')
@section('title', 'Archives')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12 m8 l9 blog-list">
            @if (count($posts) > 0)
                @foreach ($posts as $post)
                    <div class="blog-list-item">
                        <div class="row">
                            <div class="col s4 m3">
                                <a href="/session/{{ $post->id }}/edit" class="no-underline">
                                    <img src={{ $post->images->first()->getURL('medium') }} />
                                </a>
                            </div>
                            <div class="col s8 m9">
                                <h5 style="margin-top: 0; margin-bottom: 0;"><a href="/session/{{ $post->id }}/edit" class="no-underline">{{ $post->title }}</a></h5>
                                <p class="small light uppercase" style="margin-top: 3px;">by <?=(($post->authored_by) ?: $post->user->first_name.' '.$post->user->last_name)?></p>
                                @php
                                    // TODO I'm sure this could be more elegant.
                                    $parsedown = new Parsedown();
                                    $body = strip_tags($parsedown->text($post->body));
                                    $post_length = strlen($body);
                                    $index = 200;
                                @endphp
                                @if ($post_length > $index)
                                    @while ($post_length > $index && !preg_match('/\s/', $body[$index]))
                                        @php $index++; @endphp
                                    @endwhile
                                    <p class="">{{ substr($body, 0, $index) }}...</p>
                                @else
                                    <p class="">{{ $body }}</p>
                                @endif
                                <a href="/session/{{ $post->id }}/edit" class="btn sbs-red btn-small"> Update</a>
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
    </div>
</div>
@endsection
