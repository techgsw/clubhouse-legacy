@extends('layouts.clubhouse')
@section('title', 'Training')
@section('content')
    <div class="container" style="padding-top:40px;">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
        <div class="row">
            <h5 class="center-align"><strong style="text-transform:uppercase;">Sports Industry Training Videos</strong></h5>
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
                <a href="/training/training-videos" class="btn sbs-red" style="margin-bottom: 10px;">See all videos</a>
            </div>
        </div>
        <hr style="color:#FFF;"/>
    </div>
@endsection
