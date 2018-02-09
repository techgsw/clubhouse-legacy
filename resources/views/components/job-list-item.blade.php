<a href="{{ $job->getURL() }}">
    <div class="row job-index {{ $job->featured ? 'featured-job' : '' }}">
        <div class="col s3 m2 center-align">
            <img style="margin-top: 12px;" src={{ Storage::disk('local')->url($job->image_url) }} class="thumb">
        </div>
        <div class="col s9 m7">
            <h5>{{ $job->title }}</h5>
            <p style="font-size: 16px; letter-spacing: .6px; font-weight: 700; margin: 0 0 6px 0;">{{ $job->organization }}</p>
            <p style="margin: 0 0 6px 0;"><i class="fa fa-map-pin icon-left" aria-hidden="true"></i>{{ $job->city }}, {{ $job->state }}</p>
            <p class="small tags">
                @if ($job->isNew())
                    <span class="label blue white-text" style="letter-spacing: 0.6px;"><b>NEW</b></span>
                @endif
            </p>
        </div>
        <div class="col s12 m3 center-align hide-on-small-only">
            <div>
                @can ('create-inquiry')
                    <a style="margin-top: 12px;" href="{{ $job->getURL() }}" class="btn white black-text">Apply now</a>
                @else
                    <a style="margin-top: 12px;" href="/register" class="btn white black-text">Join to apply</a>
                @endcan
            </div>
            @can ('edit-job', $job)
                <div class="small" style="margin-top: 16px;">
                    <a href="/job/{{ $job->id }}/edit" class="flat-button small blue"><i class="fa fa-pencil"></i></a>
                    @if ($job->featured)
                        <a href="/job/{{ $job->id }}/unfeature" class="flat-button small blue"><i class="fa fa-star"></i> {{ $job->rank }}</a>
                        <a href="/job/{{ $job->id }}/rank-top" class="flat-button small blue"><i class="fa fa-angle-double-up"></i></a>
                        <a href="/job/{{ $job->id }}/rank-up" class="flat-button small blue"><i class="fa fa-arrow-up"></i></a>
                        <a href="/job/{{ $job->id }}/rank-down" class="flat-button small blue"><i class="fa fa-arrow-down"></i></a>
                    @else
                        <a href="/job/{{ $job->id }}/feature" class="flat-button small blue"><i class="fa fa-star-o"></i></a>
                    @endif
                </div>
            @endcan
            <div style="margin-top: 10px;">
                <a class="no-underline" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode($job->getURL($absolute=true))?>"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                <a class="no-underline" target="_blank" href="https://twitter.com/intent/tweet?text=<?=urlencode($job->getURL($absolute=true))?>"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                <a class="no-underline" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?=urlencode($job->getURL($absolute=true))?>&title=<?=urlencode($job->title)?>&source=Sports Business Solutions')?>"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                <a class="no-underline" target="_blank" href="mailto:?Subject=<?=$job->title?> | Sports Business Solutions&body=<?=urlencode($job->getURL($absolute=true))?>"><i class="fa fa-envelope-square fa-16x" aria-hidden="true"></i></a>
            </div>
        </div>
    </div>
</a>
