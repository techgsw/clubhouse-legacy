@component('emails.layout')
    @slot('body')
        <p><a href="{{ config('app.url') }}/user/{{ $registrant->id }}/profile">{{ $registrant->getName() }}</a> just registered.</p>
    @endslot
@endcomponent
