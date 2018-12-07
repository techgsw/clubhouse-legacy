@component('emails.layout')
    @slot ('title')
        Cancel Notification - theClubhouse
    @endslot
    @slot('body')
        <p>Hey <span style="color: #EB2935;">the</span>Clubhouse Team,</p>
        <p>{{ ucwords($user->first_name) }} {{ ucwords($user->last_name) }} ({{ $user->email }}) has just canceled their Clubhouse Pro subscription.</p>
        <br />
        <p>Thanks,<br/><span style="color: #EB2935;">the</span>Clubhouse App</p>
    @endslot
@endcomponent
