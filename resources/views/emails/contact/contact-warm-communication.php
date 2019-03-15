@component('emails.layout')
    @slot('body')
        <p>Hi {{$user->first_name}}, hope all is well!</p>
        <p>Your name came back across my desk today and I wanted to reach out as I thought you may be a good fit for one of the new job opportunities we are currently supporting with the (team/business) as they are seeking a (job title) to join their team.</p>
        <p>I was unsure if you were open to considering anything new at this time, but please let me know what you think and happy to jump on a call and discuss further.</p>
        <p>Thanks, and I look forward to hearing from you soon!</p>
        <p>All the best, Jason</p>
    @endslot
@endcomponent
