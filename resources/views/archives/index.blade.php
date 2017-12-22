<!-- /resources/views/blog/index.blade.php -->
@extends('layouts.default')
@section('title', 'Archive')
@section('hero')
    <div class="row hero">
        <div class="col s12">
            <h4 class="header">Sports Business Archives</h4>
            <p>We go all over the country conducting sales training, keynote speeches, hiring events and more. Check out all the places we’ve been!</p>
        </div>
    </div>
@endsection
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
            <img src="/images/archives/client-map.jpg" alt="Client Map" />
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Past sessions</h4>
            <hr />
                <div class="center">
                    @if (count($sessions) > 0)
                        @foreach ($sessions as $index => $session)
                            @if (!is_null($session->image_url))
                                @if (preg_match('/\/uploads\//', $session->image_url))
                                    <div class="session-image" style="background-image: url('{{ $session->image_url }}')">
                                        <img class="materialboxed" style="" data-caption="{{ $session->title }}" src="{{ $session->image_url }}" />
                                    </div>
                                @else
                                    <div class="session-image" style="background-image: url('{{ Storage::disk('local')->url($session->image_url) }}')">
                                        <img class="materialboxed" style="" data-caption="{{ $session->title }}" src="{{ Storage::disk('local')->url($session->image_url) }}" />
                                    </div>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12 center">
            <a href="/gallery" class="btn sbs-red">View Gallery</a>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Press releases</h4>
            <hr />
        </div>
    </div>
    <div class="row center">
        <div class="col s6 m3">
            <div class="press-release">
                <p>09.12.14</p>
                <h6>Launch of SBS</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
        <div class="col s6 m3">
            <div class="press-release">
                <p>10.01.14</p>
                <h6>Sales Combine Purchase</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
        <div class="col s6 m3">
            <div class="press-release">
                <p>11.12.14</p>
                <h6>PHX Sales Combine 2014</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
        <div class="col s6 m3">
            <div class="press-release">
                <p>12.16.14</p>
                <h6>MN Sales Combine 2014</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
    </div>
    <div class="row center">
        <div class="col s6 m3">
            <div class="press-release">
                <p>03.09.15</p>
                <h6>NJ Sales Combine 2015</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
        <div class="col s6 m3">
            <div class="press-release">
                <p>08.31.15</p>
                <h6>50 job candidates placed</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
        <div class="col s6 m3">
            <div class="press-release">
                <p>12.07.15</p>
                <h6>DET Sales Combine 2015</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
        <div class="col s6 m3">
            <div class="press-release">
                <p>12.30.15</p>
                <h6>SBS adding Recruiting & Training</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
    </div>
    <div class="row center">
        <div class="col s6 m3">
            <div class="press-release">
                <p>02.29.16</p>
                <h6>SJ Sales Combine 2016</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
        <div class="col s6 m3">
            <div class="press-release">
                <p>03.30.16</p>
                <h6>New hire Jason Stein</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
        <div class="col s6 m3">
            <div class="press-release">
                <p>06.14.17</p>
                <h6>New hire Mike Rudner</h6>
                <p class="fa fa-newspaper-o fa-2x"></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Other contributions</h4>
            <hr />
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Training videos</h4>
            <hr />
        </div>
    </div>
</div>
@endsection
