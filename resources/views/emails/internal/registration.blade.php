@component('emails.layout')
    @slot('body')
        <p><a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $registrant->id }}/profile">{{ $registrant->getName() }}</a> just registered.</p>
    @endslot
@endcomponent
