@if (!preg_match('/do not show/i', $product->name))
    <div style="display:flex;align-items: center; justify-content:space-between;margin: 5px 0px;">
        <a href="{{ $product->getURL(false, 'webinars') }}" class="no-underline"><i style="font-size:70px;color:#EB2935; margin-right:20px;" class="fa fa-caret-right"></i></a>
        <a href="{{ $product->getURL(false, 'webinars') }}" class="webinar-list-title" style="font-size: 18px;margin-right:auto;max-width:650px;"><strong>{{ $product->name }}</strong></a>
        <div class="hide-on-small-and-down" style="min-width:150px;height:2em;line-height: 100%; overflow: hidden; text-align: right;">
            @foreach($product->tags as $tag)
                @if ($tag->name != 'Webinar')
                    <a href="/webinars?tag={{ urlencode($tag->slug) }}" class="small flat-button black" style="margin:4px;white-space: nowrap;">{{ $tag->name }}</a>
                @endif
            @endforeach
        </div>
        <span class="sbs-red-text" style="margin-left:15px;white-space: nowrap;">
            @if ($product->highest_option_role == 'clubhouse')
                @cannot('view-clubhouse')
                    <a href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" class="no-underline">
                @endcannot
                        <strong>PRO Member</strong>
                @cannot('view-clubhouse')
                    </a>
                @endcannot
            @elseif ($product->highest_option_role == 'user' && !Auth::user())
                <a href="#register-modal" class="no-underline"><strong>FREE Sign up</strong></a>
            @else
                <strong>FREE</strong>
            @endif
        </span>
    </div>
    <div class="hide-on-med-and-up">
        <hr style="color:#EB2935;margin:unset;">
    </div>
@endif
