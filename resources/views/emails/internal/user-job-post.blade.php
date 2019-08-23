@component('emails.layout')
    @slot('body')
        <p><a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/job-postings">{{ $user->getName() }}</a> just posted a job.</p>
    @endslot
@endcomponent
