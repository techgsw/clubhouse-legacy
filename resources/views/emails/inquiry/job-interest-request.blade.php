@component('emails.layout')
    @slot('body')
        <h1>Inquiry</h1>
        <p>Hi {{$inquiry->user->first_name}}, hope all is well!</p>
        <p>Your name came back across my desk today and I wanted to reach out as I thought you may be a good fit for one of the new job opportunities we are currently supporting with the {{$inquiry->job->organization_name}} as they are seeking a {{$inquiry->job->title}} to join their team.</p>
        <p>I was unsure if you were open to considering anything new at this time, but please let me know what you think and happy to jump on a call and discuss further.</p>
        <p>Thanks, and I look forward to hearing from you soon!</p>

        <a href="{{ env('CLUBHOUSE_URL') }}/inquiry/{{ $inquiry->id }}/feedback?interest=interested&token={{ $inquiry->job_interest_token }}">I am interested</a>
        <br/>
        <a href="{{ env('CLUBHOUSE_URL') }}/inquiry/{{ $inquiry->id }}/feedback?interest=not_interested&token={{ $inquiry->job_interest_token }}">I am not interested</a>
        <br/>
        <a href="{{ env('CLUBHOUSE_URL') }}/inquiry/{{ $inquiry->id }}/feedback?interest=dnc&token={{ $inquiry->job_interest_token }}">WhO aRe yOU aND hOw dID yOu GeT tHiS EmaIL??</a>
    @endslot
@endcomponent
