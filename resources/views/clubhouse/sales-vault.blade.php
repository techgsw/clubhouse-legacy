@extends('layouts.clubhouse')
@section('title', 'Sport Sales Training')
@section('hero')
    <div class="row hero bg-image sales-vault">
        <div class="col s12" style="margin-bottom:10px;">
            <img class="responsive-img" src="/images/sales-vault/treasure.png" />
            <h4 class="header">The Sport Sales Vault</h4>
            <h5 style="font-size:25px;">Sales training videos produced by the team at <a href="{{env('APP_URL')}}">SBS Consulting</a></h5>
            <h5 style="max-width:1050px;font-size:19px;text-align: center;margin-left:auto;margin-right:auto;">We've trained more than 100 sports teams throughout the US and Canada, conducted more than 350 sales training sessions and trained over 1,000 salespeople in sports.</h5>
        </div>
        <div class="col s12 center-align" style="margin-top:20px;">
            <a href="/sales-vault/training-videos" class="btn sbs-red">See all videos</a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container" style="padding-top:40px;">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
        <div class="row">
            <h5 class="center-align"><strong style="text-transform:uppercase;">Sport sales training videos</strong></h5>
            <div class="sales-vault-video-container">
                @foreach($newest_training_videos as $video)
                    <div class="sales-vault-video">
                        <iframe src="https://player.vimeo.com/video/{{ $video->getEmbedCode() }}" frameborder="0" allowFullScreen mozallowfullscreen webkitAllowFullScreen></iframe>
                        <p>{{$video->name}}
                        @if ($video->getTrainingVideoAuthor())
                            <br><span style="font-size:13px;">by {{$video->getTrainingVideoAuthor()}}</span>
                        @endif
                        </p>
                    </div>
                @endforeach
            </div>
            <div class="center-align" style="margin-top:-20px;">
                <a href="/sales-vault/training-videos" class="btn sbs-red" style="margin-bottom: 10px;">See all videos</a>
            </div>
        </div>
        <hr style="color:#FFF;"/>
    </div>
    <div class="container" style="padding:40px 0px;">
        <div class="row center-align">
            <div class="col s12">
                <!--TODO: sbs logo image -->
            </div>
            <h5><strong style="text-transform:uppercase;">The SBS Consulting certified trainers</strong></h5>
            <div class="col s12 m10 offset-m1">
                <p>Our trainers have a combined 30+ years of sport sales experience. They've all sold and lead sales teams themselves and have a passion to coach and teach. Their experience covers all aspects of sport sales including but not limited to: B2C, B2B, Group Sales, Retention, Corporate Partnerships and the "Sales 101 basics".</p>
            </div>
            <div class="about-cards col s12 l8 offset-l2" style="padding-top:20px;">
                <div class="about-card col s6 m6">
                    <a href="{{env('APP_URL')}}/bob-hamer" class="no-underline">
                        <img src="/images/about/bob.png" style="width: 80%; max-width: 180px; border-radius: 50%;">
                        <h5 class="sbs-red-text">Bob Hamer<span class="about-position">Founder &amp; President</span></h5>
                    </a>
                </div>
                <div class="about-card col s6 m6">
                    <a href="{{env('APP_URL')}}/josh-belkoff" class="no-underline">
                        <img src="/images/about/josh.jpg" style="width: 80%; max-width: 180px; border-radius: 50%;">
                        <h5 class="sbs-red-text">Josh Belkoff<span class="about-position">Sr. Director,<br/>Business Development</span></h5>
                    </a>
                </div>
            </div>
            <div class="col s12 m10 offset-m1" style="margin-top:20px;">
                <h5>Interested in a training for your sales team? <a href="{{env('APP_URL')}}/contact">Contact us.</a></h5>
            </div>
        </div>
    </div>
@endsection
