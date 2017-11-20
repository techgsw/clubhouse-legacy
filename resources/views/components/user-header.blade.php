<div class="row">
    <div class="col s12 m6">
        <div class="row">
            <div class="col s4 center-align">
                @if (!is_null($user->profile))
                    @if ($user->profile->headshot_url)
                        <img src={{ Storage::disk('local')->url($user->profile->headshot_url) }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px;" />
                    @else
                        <i class="material-icons large">person</i>
                    @endif
                @else
                    <i class="material-icons large">person</i>
                @endif
            </div>
            <div class="col s8">
                <h3 class="header" style="display: inline-block; margin-bottom: 10px;">{{ $user->getName() }}</h3>
                <p style="margin: 4px 0;"><a href="mailto:{{ $user->email}}">{{ $user->email}}</a></p>
                @if (!is_null($user->profile))
                    <p style="margin: 4px 0;">@component('components.phone', [ 'phone'=> $user->profile->phone ]) @endcomponent</p>
                @else
                    <p style="margin: 4px 0;">@component('components.phone', [ 'phone'=> '-' ]) @endcomponent</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col s12 m6 center-align">
        {{ $slot }}
    </div>
</div>
