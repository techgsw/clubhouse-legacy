@php $pd = new Parsedown(); @endphp
<div class="col s12">
    <a href="{{ $video->getURL(false, 'sales-vault/training-videos') }}" target="_blank" rel="noopener" class="training-video-item">
        <div class="card horizontal">
            <div class="card-stacked">
                <div class="card-content">
                    @if ($video->created_at > new DateTime('-1 week'))
                        <button class="btn sbs-red new-training-video-tag" style="margin-top:-34px;margin-left:-32px;">NEW</button>
                    @endif
                    <div class="row">
                        <div class="col s12 m8">
                            <span style="font-size: 20px;margin-right:10px;"><strong>{{ $video->name }}</strong></span> {{is_null($video->getTrainingVideoAuthor()) ? '' : 'by '.$video->getTrainingVideoAuthor()}}
                            <span> {!! $pd->text($video->getCleanDescription() ) !!}</span>
                        </div>
                        <div class="hide-on-small-and-down m4">
                            <i style="font-size:70px;top:19%;position:absolute;right:40px;" class="fa fa-caret-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
