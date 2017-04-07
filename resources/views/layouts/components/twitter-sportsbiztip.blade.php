@if ($feed)
    <div id="twitter-sportsbiztip">
        <h5 class="center-align">#SportsBizTip</h5>
        <div class="row tweets">
            @foreach ($feed as $tweet)
                <div class="col s12 m4">
                    <a href="https://twitter.com/{{ $screen_name }}/status/{{ $tweet->id }}">
                        <div class="tweet">
                            <div class="icon">
                                <i class="fa fa-twitter fa-3x" aria-hidden="true" style="color: #1DA1F2;"></i>
                            </div>
                            <p>{{ $tweet->text }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col s12 center-align">
                <a href="https://twitter.com/SportsBizSol" class="twitter-follow-button" data-size="large" data-show-screen-name="false" data-show-count="false">Follow @SportsBizSol</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
            </div>
        </div>
    </div>
@endif
