<a href="{{ $job->getURL() }}">
    <div class="card medium" style="display: flex; flex-wrap: wrap; flex-flow: column; justify-content: space-between;">
        <div class="card-content">
            <div class="col s12 center">
                @if (!is_null($job->image))
                <img class="thumb" style="margin-top: 12px; max-height: 50px;" src="{{ $job->image->getURL('small') }}" />
                @endif
            </div>
            <div class="col s12 center-align">
                <h5 class="" style="font-size: 1.2rem" title="{{ $job->title }}">{{ $job->title }}</h5>
                <p style="font-size: 16px; letter-spacing: .6px; font-weight: 700; margin: 0 0 6px 0;">{{ $job->organization_name }}</p>
                <p style="margin: 0 0 6px 0;"><i class="fa fa-map-pin icon-left" aria-hidden="true"></i>{{ $job->city }}, {{ $job->state }}, {{ $job->country }}</p>
                <div style="margin-top: 10px;">
                    <a class="no-underline" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=urlencode($job->getURL($absolute=true))?>"><i class="fa fa-facebook-square fa-16x" aria-hidden="true"></i></a>
                    <a class="no-underline" target="_blank" href="https://twitter.com/intent/tweet?text=<?=urlencode($job->getURL($absolute=true))?>"><i class="fa fa-twitter-square fa-16x" aria-hidden="true"></i></a>
                    <a class="no-underline" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?=urlencode($job->getURL($absolute=true))?>&title=<?=urlencode($job->title)?>&source=Sports Business Solutions')?>"><i class="fa fa-linkedin-square fa-16x" aria-hidden="true"></i></a>
                    <a class="no-underline" target="_blank" href="mailto:?Subject=<?=$job->title?> | Sports Business Solutions&body=<?=urlencode($job->getURL($absolute=true))?>"><i class="fa fa-envelope-square fa-16x" aria-hidden="true"></i></a>
                </div>
                @if ($job->featured)
                    <span class="label sbs-red" style="letter-spacing: 0.6px; display: inline; font-size: 10px;"><b><i class="fa fa-star icon-left" aria-hidden="true"></i>FEATURED</b></span>
                @endif
                <p class="small tags">
                    @if ($job->isNew())
                        <span class="label blue white-text" style="letter-spacing: 0.6px; display: inline; font-size: 10px;"><b>NEW</b></span>
                    @endif
                </p>
            </div>
            <div class="col s12 center" style="height: 30px;">
                @can ('create-inquiry')
                    <a style="position: absolute; bottom: 15px; left: 50%; margin-left: -45px; width: 90px;" href="{{ $job->getURL() }}" class="btn btn-small  white black-text">Apply</a>
                @else
                    <a style="position: absolute; bottom: 15px; left: 50%; margin-left: -45px; width: 90px;" href="/register" class="btn btn-small white black-text">Apply</a>
                @endcan
            </div>
        </div>
    </div>
</a>
