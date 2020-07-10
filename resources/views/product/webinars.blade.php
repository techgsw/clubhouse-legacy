@php $pd = new Parsedown(); @endphp
@extends('layouts.clubhouse')
@section('title', 'Webinars')
@section('hero')
    <div class="row hero bg-image webinars">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/event-white.png" />
            <h4 class="header">Educational Webinars</h4>
            <p>Live and on demand discussions with sports industry leaders.</p>
        </div>
    </div>
@endsection
@section('content')
<div class="container">
    <div class="col s12">
        @include('layouts.components.messages')
        @include('layouts.components.errors')
    </div>
    @if(is_null($active_tag))
        <div class="row" style="margin-bottom: unset;">
            <div class="col s12">
                <h4 id="upcoming" style="font-weight: bold; text-align: center;">UPCOMING WEBINAR EVENTS</h4>
            </div>
        </div>
        <div class="row">
            @if (count($active_products) < 1)
                <h5 style="text-align: center;">Coming soon.</h5>
            @else
                @foreach ($active_products as $product)
                        <div class="col l6" style="display: flex; justify-content: center;">
                            @include('product.webinars.components.list-item', ['product' => $product])
                        </div>
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
                    : <strong>{{$active_tag->name}}</strong>
                @endif
                </h4>
            </div>
            <div class="tag-cloud center-align">
                @foreach ($tags as $tag)
                    <a href="{{'/webinars?tag='.urlencode($tag->slug) }}" class="small flat-button black" style="display: inline-block; margin: 4px;">{{ $tag->name }}</a>
                @endforeach
            </div>
            <div class="col s12 center-align" style="margin-top:20px;">
                <strong><span class="sbs-red-text">FREE Sign up</span>: Watch with a free membership</strong>
                <br>
                <strong><span class="sbs-red-text">PRO Member</span>: Watch with a Clubhouse PRO membership</strong>
                <br>
                <strong><span class="sbs-red-text">WATCH NOW</span>: No signup required</strong>
            </div>
        </div>
        <div class="row" style="max-width: 800px;margin-right:auto;margin-left:auto;">
            @foreach ($inactive_products as $product)
                @include('product.webinars.components.inactive-list-item', ['$product' => $product])
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
