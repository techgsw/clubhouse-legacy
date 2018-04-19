<div class="row" style="margin-bottom: 0;">
    <div class="col s12">
        <div style="display: flex; flex-flow: row;">
            <div style="flex: 0 0 auto;">
                @if (!is_null($user))
                    @if ($user->profile->headshotImage)
                        <img src={{ $user->profile->headshotImage->getURL('medium') }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" />
                    @endif
                @endif
            </div>
            <div style="flex: 1 0 auto;">
                <div class="hide-on-small-only float-right">
                    {{ $slot }}
                </div>
                <h3 class="header" style="margin: 14px 0 2px 0;">{{ $user ? $user->getName() : $user->getName() }}</h3>
                <p style="line-height: 1.25; margin: 3px 0;">{{ $user ? $user->getTitle() : $user->getTitle() }}</p>
                @if (!is_null($user->email))
                    <p style="line-height: 1.25; margin: 3px 0;"><a class="no-underline" href="mailto:{{ $user->email }}">{{ $user->email}}</a></p>
                @endif
                @if (!is_null($user->profile->phone))
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
