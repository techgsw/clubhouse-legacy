<div class="col s12">
    @can('view-clubhouse')
        <a href="{{ $product->getURL(false, 'webinars') }}" target="_blank" rel="noopener" class="no-underline">
            <div class="card medium">
                <div class="card-content">
                    <div class="">
                        <div style="font-size: 20px; margin-right: 10px; margin-bottom: 1rem;"><strong>{{ $product->name }}</strong></div>
                    </div>
                    <div class="col s12" style="height: 40px;">
                        <div style="position: absolute; bottom: 10px; padding-right: 10px;">
                            @foreach($product->tags as $tag)
                                <a href="{{ $url . " tag=" . urlencode($tag->slug) }}" class="flat-button black small" style="margin:2px;">{{ $tag->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @else
        <div class="card small">
            <div class="card-content">
                <div style="font-size: 20px; margin-right: 10px; margin-bottom: 1rem;"><strong>{{ $product->name }}</strong></div>

                <div class="col s12 center" style="height: 40px;">
                    <div style="position: absolute; bottom: 10px; left: 0; width: 100%; text-align: center;">
                        @if ($product->highest_option_role == 'clubhouse')
                            <a href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" class="no-underline">
                                <h6><strong class="sbs-red-text">
                                    PRO Member
                                </strong></h6>
                            </a>
                        @elseif ($product->highest_option_role == 'user' && !Auth::user())
                            <a href="#register-modal" class="no-underline">
                                <h6><strong class="sbs-red-text">
                                    FREE Sign up
                                </strong></h6>
                            </a>
                        @else
                            <a href="{{ $product->getURL(false, 'webinars') }}" target="_blank" rel="noopener" class="no-underline">
                                <h6><strong class="sbs-red-text">
                                    WATCH NOW
                                </strong></h6>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    @endcan
</div>
