@if (!preg_match('/do not show/i', $product->name))
    <div style="display:flex;align-items: center; justify-content:space-between;margin: 5px 0px;">
        <a href="{{ $product->getURL(false, 'webinars') }}" target="_blank" rel="noopener" class="no-underline"><i style="font-size:70px;color:#EB2935; margin-right:20px;" class="fa fa-caret-right"></i></a>
        <a href="{{ $product->getURL(false, 'webinars') }}" target="_blank" rel="noopener" class="webinar-list-title" style="font-size: 18px;margin-right:auto;max-width:650px;"><strong>{{ $product->name }}</strong></a>
        <span class="sbs-red-text" style="margin-left:15px;white-space: nowrap;">
            @can('view-clubhouse')
                <a href="{{ $product->getURL(false, 'webinars') }}" target="_blank" rel="noopener" class="no-underline"><strong>WATCH NOW</strong></a>
            @else
                @if ($product->highest_option_role == 'clubhouse')
                    <a href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}" class="no-underline">
                        <strong>PRO Member</strong>
                    </a>
                @elseif ($product->highest_option_role == 'user' && !Auth::user())
                    <a href="#register-modal" class="no-underline"><strong>FREE Sign up</strong></a>
                @else
                    <a href="{{ $product->getURL(false, 'webinars') }}" target="_blank" rel="noopener" class="no-underline"><strong>WATCH NOW</strong></a>
                @endif
            @endcan
        </span>
    </div>
    <div class="hide-on-med-and-up">
        <hr style="color:#EB2935;margin:unset;">
    </div>
@endif
