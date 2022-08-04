<div class="col s12">
    <a href="{{ $video->getURL(false, 'training/training-videos') }}" target="_blank" rel="noopener" class="training-video-item">
        <div class="card large">
            <div class="card-content">
                @if ($video->created_at > new DateTime('-1 week'))
                    <button class="btn sbs-red new-training-video-tag" style="margin-top:-34px;margin-left:-32px;">NEW</button>
                @endif
                <div class="">
                    <div style="font-size: 20px; margin-right: 10px; margin-bottom: 1rem;"><strong>{{ $video->name }}</strong></div>
                    <div>{{is_null($video->getTrainingVideoAuthor()) ? '' : 'by '.$video->getTrainingVideoAuthor()}}</div>
                    <div> {{ strip_tags($video->blurb) }}</div>
                </div>
                <div class="row center-align">
                    <div class="col center-align" style="position: absolute; bottom: 10rem; margin-right: 1vw;">
                        @if($video->primaryImage())
                            <img src={{ $video->primaryImage()->getURL('medium') }} width="100%"/>
                        @endif
                    </div>
                </div>
                <div class="col s12" style="height: 40px;">
                    <div style="position: absolute; bottom: 10px; padding-right: 10px;">
                        @foreach($video->tags as $tag)
                            <a href="{{ $url . " tag=" . urlencode($tag->slug) }}" class="flat-button black small" style="margin:2px;">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
