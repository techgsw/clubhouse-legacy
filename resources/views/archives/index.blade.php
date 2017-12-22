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
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>09.12.14</p>
                <h6>Launch of SBS</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>10.01.14</p>
                <h6>Sales Combine Purchase</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>11.12.14</p>
                <h6>PHX Sales Combine 2014</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>12.16.14</p>
                <h6>MN Sales Combine 2014</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>03.09.15</p>
                <h6>NJ Sales Combine 2015</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>08.31.15</p>
                <h6>50 job candidates placed</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>12.07.15</p>
                <h6>DET Sales Combine 2015</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>12.30.15</p>
                <h6>SBS adding Recruiting & Training</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>02.29.16</p>
                <h6>SJ Sales Combine 2016</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>03.30.16</p>
                <h6>New hire Jason Stein</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" href="#">
                <p>06.14.17</p>
                <h6>New hire Mike Rudner</h6>
                <p class="icon fa fa-newspaper-o fa-2x"></p>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Other contributions</h4>
            <hr />
        </div>
    </div>
    <div class="row center">
        <div class="col s6 m4">
            <a class="publication" target="_blank" href="http://collegead.com/roadmap-getting-job-sports/">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">College AD</h6>
                    <h6 class="title">How to get a job in sports</h6>
                </div>
            </a>
        </div>
        <div class="col s6 m4">
            <a class="publication" target="_blank" href="http://collegead.com/secrets-selling-large-donors/">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">College AD</h6>
                    <h6 class="title">The secrets of selling to large donors</h6>
                </div>
            </a>
        </div>
        <div class="col s6 m4">
            <a class="publication" target="_blank" href="http://sportscareers.about.com/od/interviews/fl/Sport-Sales-Combine-Your-Ticket-to-A-Sports-Sales-Career.htm">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">about.com</h6>
                    <h6 class="title">Getting a job in sports</h6>
                </div>
            </a>
        </div>
        <div class="clearfix hide-on-small-only"></div>
        <div class="col s6 m4">
            <a class="publication" target="_blank" href="http://collegead.com/get-promoted-sports-business-job/">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">College AD</h6>
                    <h6 class="title">How to get promoted in your sports business job</h6>
                </div>
            </a>
        </div>
        <div class="col s6 m4">
            <a class="publication" target="_blank" href="http://sportstaopodcast.libsyn.com/ep-419-bob-hamer-ceo-sports-business-solutions">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">The Tao of Sports</h6>
                    <h6 class="title">The Sports Sales Combine</h6>
                </div>
            </a>
        </div>
        <div class="col s6 m4">
            <a class="publication" target="_blank" href="http://www.frontofficesports.org/interviews/11/15/an-in-depth-look-at-the-sports-sales-combine-with-bob-hamer">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">Front Office Sports</h6>
                    <h6 class="title">The Sports Sales Combine</h6>
                </div>
            </a>
        </div>
        <div class="clearfix hide-on-small-only"></div>
        <div class="col s6 m4">
            <a class="publication" target="_blank" href="http://www.frontofficesports.org/interviews/12/18/from-one-side-of-the-desk-to-another-how-a-passion-for-helping-others-turned-an-idea-into-a-new-business-venture?rq=Bob%20Hamer">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">Front Office Sports</h6>
                    <h6 class="title">Launching Sports Business Solutions</h6>
                </div>
            </a>
        </div>
        <div class="col s6 m4">
            <a class="publication" target="_blank" href="http://sportsgeekhq.com/podcast/bob-hamer-sales-success-sports/">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">The Sports Geek Podcast</h6>
                    <h6 class="title">Interview with SBS President, Bob Hamer</h6>
                </div>
            </a>
        </div>
        <div class="col s6 m4">
            <a class="publication" target="_blank" href="http://alsd.com/content/podcast-bob-hamer">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">ALSD (Association of Luxury Suite Directors)</h6>
                    <h6 class="title">Podcast with Bob Hamer & Brett Zalaski</h6>
                </div>
            </a>
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
