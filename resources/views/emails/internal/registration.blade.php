@component('emails.layout')
    @slot('body')
        <p>{{ $registrants->count() }} registered between {{ $start->format('m/d/Y H:i:s') }} and {{ $end->format('m/d/Y H:i:s') }}</p>
        <ul>
            @foreach ($registrants->get() as $user)
                <li><a href="{{ config('app.url') }}">{{ $user->getName() }}</a> (<a href="mailto:{{ $user->email }}">{{ $user->email}}</a>)</li>
            @endforeach
        </ul>
    @endslot
@endcomponent
