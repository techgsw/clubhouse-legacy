@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }} - Thanks for signing up to be a <strong>Clubhouse “Pro”</strong>.</p>
        <p>It means a lot to have you as part of our community.</p>
        <br>
        <p>-<span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
    @endslot
@endcomponent
