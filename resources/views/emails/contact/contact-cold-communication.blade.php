@component('emails.layout')
    @slot('body')
        <p>Hi {{$contact->contact->first_name}}</p>
        <p>Hope all is well!  Your information came across my desk earlier and I wanted to reach out as I thought you may be a good fit for one of the new job opportunities we are currently supporting with the {{$contact->job->organization_name}} as they are seeking a {{$contact->job->title}} to join their team.</p>
        <p>I was unsure if you may be considering anything new at this time, or if this would be something of interest, but let me know what you think and I would be more than happy to jump on a call and discuss further.</p>
        <p>Thank you in advance for your consideration and I look forward to hearing from you soon!</p>
        <p>All the best,</p>
        <p>Jason</p>
    @endslot
@endcomponent
