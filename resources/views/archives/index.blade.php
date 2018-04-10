@extends('layouts.default')
@section('title', 'Archive')
@section('hero')
    <div class="row bg-image hero archives">
        <div class="col s12">
            <h4 class="header">Sports Business Archives</h4>
            <p>We go all over the country conducting sales training, keynote speeches, hiring events and more.</p>
            <a href="#past-sessions" class="btn btn-large sbs-red">VIEW GALLERY</a>
            <a href="#other-contributions" class="btn btn-large sbs-red">MEDIA CONTRIBUTIONS</a>
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
        <div class="col s12 center">
            <h4>Check out all the places we’ve been!</h4>
            <img src="/images/archives/client-map.jpg" alt="Client Map" />
        </div>
    </div>
    <div class="row" id="past-sessions">
        <div class="col s12">
            <a name="sessions"></a>
            <h4>Past sessions</h4>
            <hr />
                <div class="center">
                    @if (count($sessions) > 0)
                        @foreach ($sessions as $index => $session)
                            @foreach ($session->images as $index => $image)
                                @php
                                    $image_path = $session->getImagePath($image, 'medium');
                                @endphp
                                <div class="session-image" style="background-image: url('{{ Storage::disk('local')->url($image_path) }}')">
                                    <div class="overlay">
                                        <span class="overlay-text">{{ $session->title }}</span>
                                    </div>
                                    <img class="materialboxed" style="" data-caption="{{ $session->title }}" src="{{ Storage::disk('local')->url($image_path) }}" />
                                </div>
                            @endforeach
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
            <a class="press-release" target="_blank" href="http://www.sportsbusiness.solutions/storage/press-release/SBS-Final-Press-Release-09.12.14.pdf">
                <p>09.12.14</p>
                <h6>Launch of SBS</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="http://www.sportsbusiness.solutions/storage/press-release/SBS-Press-Release-Combine-10.01.141.doc">
                <p>10.01.14</p>
                <h6>Sales Combine Purchase</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="http://www.sportsbusiness.solutions/storage/press-release/SBS-Press-Release-PHX-Combine-2014.doc">
                <p>11.12.14</p>
                <h6>PHX Sales Combine 2014</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="http://www.sportsbusiness.solutions/storage/press-release/SBS-Press-Release-Minny-Combine-2014.doc">
                <p>12.16.14</p>
                <h6>MN Sales Combine 2014</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="http://www.sportsbusiness.solutions/storage/press-release/SBS-Press-Release-Devils-Combine-2015.doc">
                <p>03.09.15</p>
                <h6>NJ Sales Combine 2015</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="http://www.sportsbusiness.solutions/storage/press-release/SBS-Press-Release-50-Candidates-Placed.pdf">
                <p>08.31.15</p>
                <h6>50 job candidates placed</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="http://www.sportsbusiness.solutions/storage/press-release/SBS-Press-Release-Pistons-Combine-2015.doc">
                <p>12.07.15</p>
                <h6>DET Sales Combine 2015</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="http://www.sportsbusiness.solutions/storage/press-release/SBS-Press-Release-Training-Recruiting.pdf">
                <p>12.30.15</p>
                <h6>SBS adding Recruiting & Training</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="http://www.sportsbusiness.solutions/storage/press-release/SBS-Press-Release-Sharks-Combine-2016.pdf">
                <p>02.29.16</p>
                <h6>SJ Sales Combine 2016</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="http://www.sportsbusiness.solutions/storage/press-release/SBS-New-Hire-Press-Release-Jason-Stein.pdf">
                <p>03.30.16</p>
                <h6>New hire Jason Stein</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="https://sportsbusiness.solutions/storage/press-release/SBS-New-Hire-Press-Release-Mike-Rudner-Final.docx">
                <p>06.14.17</p>
                <h6>New hire Mike Rudner</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
        <div class="col s6 m4 l3">
            <a class="press-release" target="_blank" href="https://sportsbusiness.solutions/storage/press-release/SBS-NewHirePressRelease-AdamVogel.pdf">
                <p>03.26.18</p>
                <h6>New hire Adam Vogel</h6>
                <p class="icon fa fa-chevron-circle-right fa-2x"></p>
            </a>
        </div>
    </div>
    <div class="row" id="other-contributions">
        <div class="col s12">
            <h4>Other contributions</h4>
            <hr />
        </div>
    </div>
    <div class="row center">
        <div class="clearfix hide-on-small-only"></div>
        <div class="col s12 m4">
            <a class="publication" target="_blank" href="https://www.bizjournals.com/phoenix/news/2018/04/03/pitching-baseball-to-younger-fans-as-sports.html">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">Phoenix Business Journal</h6>
                    <h6 class="title">Pitching baseball to younger fans</h6>
                </div>
            </a>
        </div>
        <div class="col s12 m4">
            <a class="publication" target="_blank" href="http://sportspr.com/sportsprnews/2016/12/8/how-curiosity-can-grow-your-sports-business-career">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">SportsPR.com</h6>
                    <h6 class="title">How curiosity can grow your sports business career</h6>
                </div>
            </a>
        </div>
        <div class="col s12 m4">
            <a class="publication" target="_blank" href="http://www.jakekelfer.com/blog/control-what-you-can-control">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">Jake Kelfer</h6>
                    <h6 class="title">Success Spotlight with Bob Hamer</h6>
                </div>
            </a>
        </div>
        <div class="clearfix hide-on-small-only"></div>
        <div class="col s12 m4">
            <a class="publication" target="_blank" href="http://www.thebusinessofsports.com/2015/10/12/inside-the-sportsbiz-studio-bob-hamer/">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">Business of Sports</h6>
                    <h6 class="title">Inside the SportsBiz Studio: Bob Hamer</h6>
                </div>
            </a>
        </div>
        <div class="col s12 m4">
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
        <div class="col s12 m4">
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
        <div class="clearfix hide-on-small-only"></div>
        <div class="col s12 m4">
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
        <div class="col s12 m4">
            <a class="publication" target="_blank" href="http://collegead.com/roadmap-getting-job-sports/">
                <div class="publication-icon">
                    <div class="icon fa fa-newspaper-o fa-2x"></div>
                </div>
                <div class="publication-text">
                    <h6 class="venue">UW Madison SBC</h6>
                    <h6 class="title">Speaker Spotlight: Bob Hamer</h6>
                </div>
            </a>
        </div>
        <div class="col s12 m4">
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
        <div class="clearfix hide-on-small-only"></div>
        <div class="col s12 m4">
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
        <div class="col s12 m4">
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
    <div class="row">
        <div class="col s6 m4">
            <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/ekb485jEUa0" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col s6 m4">
            <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/j_5iRA5Mvhw" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col s6 m4">
            <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/qetx_GkXfiU" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col s6 m4">
            <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/PeDsajOlRw0" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col s6 m4">
            <div class="video-wrapper">
                <iframe src="https://www.youtube.com/embed/tEhNxzVTE94" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>

    </div>
</div>
@endsection
