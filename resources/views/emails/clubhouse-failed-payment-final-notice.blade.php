@component('emails.layout')
    @slot('body')
        <p>Hey {{$user->first_name}},</p>
        <p>We've made {{$attempt_count}} attempts to charge your card for your Clubhouse PRO subscription, and so far, all attempts have failed.</p>
        <p>We'll try charging your card one more time on {{$next_attempt_date->format('m/d/Y')}}. If this transaction still fails, your PRO subscription will be cancelled.</p>
        <p>We don't want you to lose your PRO benefits, so please add a new card and make it the primary card from <a href="{{env('CLUBHOUSE_URL')}}/user/{{$user->id}}/account">your account page</a>.</p>
        <p>If you still need assistance, feel free to email <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a> for more help.</p>
    @endslot
@endcomponent
