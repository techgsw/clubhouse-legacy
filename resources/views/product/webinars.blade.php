@php $pd = new Parsedown(); @endphp
@extends('layouts.clubhouse')
@section('title', 'Webinars')
@section('hero')
    <div class="row hero bg-image webinars">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/event-white.png" />
            <h4 class="header">Educational Webinars</h4>
            <p>Join these live events for FREE and listen in as sports industry pros discuss the topics of the day.</p>
            <a href="{{is_null($active_tag) ? '#upcoming' : '/webinars#upcoming'}}" class="btn btn-large sbs-red">UPCOMING WEBINAR EVENTS</a>
            <a href="{{is_null($active_tag) ? '#past' : '/webinars#past'}}" class="btn btn-large sbs-red">PAST WEBINAR EVENTS</a>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    @if(is_null($active_tag))
        <div class="row">
            <div class="col s12">
                <p>These virtual events are a chance for you to interact with some of the most respected sports industry professionals in the business.</p>
                <p>The guest speakers and members of <span class="sbs-red-text">the</span>Clubhouse team will have a conversation about topics in sports business, and you can follow along from the comfort of your phone or home computer! You can message in questions and we’ll ask them on air in real time.</p>
                <p>The live events are FREE. If you'd like to access the past shows in our archive, simply upgrade your membership to become a <strong><a class="no-underline" href="/pro-membership">Clubhouse Pro</a></strong> and start watching today!</p>
                <p>This is an affordable way to learn from some of the best in the business. See you in <span class="sbs-red-text">the</span>Clubhouse.</p>
                <br />
                <h4 id="upcoming" style="font-weight: bold; text-align: center;">UPCOMING WEBINAR EVENTS</h4>
            </div>
        </div>
        <div class="row">
            @if (count($active_products) < 1)
                <h5 style="text-align: center;">Coming soon.</h5>
            @else
                @foreach ($active_products as $product)
                    @if (is_null(array_first($product->tags, function ($tag) { return $tag->name == '#SameHere'; })))
                        <div class="col l6">
                            @include('product.webinars.components.list-item', ['product' => $product])
                        </div>
                    @else
                        <div class="col l6">
                            @include('same-here.webinars.components.list-item', ['product' => $product])
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        <hr class="sbs-red" style="color: #EB2935;" />
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
                    <a href="{{$tag->name == '#SameHere' ? '/same-here/webinars' : '/webinars?tag='.urlencode($tag->slug) }}" class="flat-button black" style="display: inline-block; margin: 4px;">{{ $tag->name }}</a>
                @endforeach
            </div>
        </div>
        <div class="row">
            @foreach ($inactive_products as $product)
                @if (!preg_match('/do not show/i', $product->name))
                    <div class="col s12">
                        <ul class="browser-default">
                            <li><span style="font-size: 18px;"><strong>{{ $product->name }}</strong></span><span> {!! $pd->text($product->getCleanDescription() ) !!}</span><a href="{{ $product->getURL(false, 'webinars') }}" class="btn sbs-red">View Webinar</a>
                                <div class="hide-on-med-and-up" style="height: 10px"><br></div>
                                @foreach($product->tags as $tag)
                                    @if ($tag->name != 'Webinar')
                                        <a href="/webinars?tag={{ urlencode($tag->slug) }}" class="small flat-button black" style="display: inline-block; margin:4px; float: right">{{ $tag->name }}</a>
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
