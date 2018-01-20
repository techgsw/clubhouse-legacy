<div class="row" style="margin-bottom: 0;">
    <div class="col s12">
        <div class="row">
            <div class="col s4 m2 center-align">
                @if (!is_null($user->profile))
                    @if ($user->profile->headshot_url)
                        <img src={{ Storage::disk('local')->url($user->profile->headshot_url) }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" />
                    @else
                        <i class="material-icons large">person</i>
                    @endif
                @else
                    <i class="material-icons large">person</i>
                @endif
            </div>
            <div class="col s8 m10">
                <div class="hide-on-small-only float-right">
                    {{ $slot }}
                </div>
                <h3 class="header" style="margin: 14px 0 2px 0;">{{ $user->getName() }}</h3>
                @if (!is_null($user->profile->current_title) || !is_null($user->profile->current_organization))
                    <p style="line-height: 1.25; margin: 3px 0;">{{ $user->profile->current_title ?: 'Works' }} {{ $user->profile->current_organization ? 'at ' . $user->profile->current_organization : ''  }}</p>
                @endif
                @if (!is_null($user->email))
                    <p style="line-height: 1.25; margin: 3px 0;"><a class="no-underline" href="mailto:{{ $user->email}}">{{ $user->email}}</a></p>
                @endif
                @if (!is_null($user->profile))
                    <p style="line-height: 1.25; margin: 3px 0;">@component('components.phone', [ 'phone'=> $user->profile->phone ]) @endcomponent</p>
                @else
                    <p style="line-height: 1.25; margin: 3px 0;">@component('components.phone', [ 'phone'=> '-' ]) @endcomponent</p>
                @endif
                <div class="hide-on-med-and-up" style="margin: 8px 0;">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
