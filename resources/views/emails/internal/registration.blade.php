@component('emails.layout')
    @slot('body')
        <p>{{ $registrants->count() }} registered between {{ $start->format('m/d/Y H:i:s') }} and {{ $end->format('m/d/Y H:i:s') }}</p>
    @endslot
@endcomponent
