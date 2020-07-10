@component('emails.layout')
    @slot('body')
        <p>Hey {{$user->first_name}},</p>
        <p>We attempted to charge your card for your Clubhouse PRO subscription, but the payment failed.</p>
        <p>We will continue to try charging this card another {{5 - $attempt_count}} times, starting on {{$next_attempt_date->format('m/d/Y')}}.</p>
        <p>We don't want you to lose your PRO benefits, so please add a new card and make it the primary card from <a href="{{env('CLUBHOUSE_URL')}}/user/{{$user->id}}/account">your account page</a>.</p>
        <p>If you still need assistance, feel free to email <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a> for more help.</p>
    @endslot
@endcomponent
