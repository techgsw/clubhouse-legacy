@php $pd = new Parsedown(); @endphp
@extends('layouts.clubhouse')
@section('title', 'Mental Health Discussions | #SameHere ')
@section('content')
<div class="container">
    @if(is_null($active_tag))
        <div class="row">
            <div class="col s12 center-align">
                <h2>Mental Health Discussions</h2>
            </div>
        </div>
    @endif
    @if (count($inactive_products) > 0)
        <div class="row">
            <div class="col s12">
                <h4 id="past" style="font-weight: bold; text-align: center;">PAST WEBINAR EVENTS
                @if (!is_null($active_tag))
                    MATCHING <strong>{{$active_tag->name}}</strong>
                @endif
                </h4>
            </div>
            <div class="tag-cloud center-align">
                @foreach ($tags as $tag)
                    <a href="/same-here/webinars?tag={{ urlencode($tag->slug) }}" class="flat-button black" style="display: inline-block; margin: 4px;">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="row">
            @foreach ($inactive_products as $product)
                @if (!preg_match('/do not show/i', $product->name))
                    <div class="col s12">
                        <ul class="browser-default">
                            <li><span style="font-size: 18px;"><strong>{{ $product->name }}</strong></span><span> {!! $pd->text($product->getCleanDescription() ) !!}</span><a href="{{ $product->getURL(false, 'same-here/webinars') }}" class="btn sbs-red">View Webinar</a>
                                <div class="hide-on-med-and-up" style="height: 10px"><br></div>
                                @foreach($product->tags as $tag)
                                    @if ($tag->name != 'Webinar')
                                        <a href="/same-here/webinars?tag={{ urlencode($tag->slug) }}" class="small flat-button black" style="display: inline-block; margin:4px; float: right">{{ $tag->name }}</a>
                                    @endif
                                @endforeach
                            </li>
                        </ul>
                    </div>
                @endif
            @endforeach
        </div>
        <div class="row">
            <div class="col s12 center-align">
                {{ $inactive_products->appends(request()->all())->fragment('past')->links('components.pagination') }}
            </div>
        </div>
    @elseif (!is_null($active_tag))
        <div class="row">
            <div class="col s12">
                <h4 id="past" style="font-weight: bold; text-align: center;">No past webinar events matching <strong>{{ $active_tag->name }}</strong></h4>
            </div>
        </div>
    @endif
</div>
@endsection
