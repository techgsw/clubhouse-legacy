@extends('layouts.clubhouse')
@section('title', 'Sport Sales Training')
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
                        @if ($video->created_at > new DateTime('-1 week'))
                            <button class="btn sbs-red new-training-video-tag">NEW</button>
                        @endif
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
            <h5><strong style="text-transform:uppercase;">Sales Training with SBS Consulting</strong></h5>
            <div class="col s12 m10 offset-m1">
                <p>We have years of sales experience as both individual contributors and sales leaders and have trained hundreds of sales teams both in sports and out. Our experience covers all aspects of the sales process and we specialize in both B2B and B2C sales processes. Learn more below.</p>
            </div>
            <div class="about-cards col s12 l8 offset-l2" style="padding-top:20px;">
                <div class="about-card col s12">
                    <a href="{{env('APP_URL')}}/training-consulting" class="no-underline sbs-logo-link">
                        <img src="/images/sbs_consulting_logo.png" style="width: 80%; max-width: 180px;" alt="SBS Consulting">
                    </a>
                </div>
            </div>
            <div class="col s12 m10 offset-m1" style="margin-top:20px;">
                <h5>Interested in a training for your sales team? <a href="{{env('APP_URL')}}/contact">Contact us.</a></h5>
            </div>
        </div>
    </div>
@endsection
