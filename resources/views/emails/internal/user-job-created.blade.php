@component('emails.layout')
    @slot('body')
        <p><a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">{{ $user->getName() }}</a> just created a <a href="{{ env('CLUBHOUSE_URL') }}/job/{{ $job->id }}">job</a>.</p>
    @endslot
@endcomponent
