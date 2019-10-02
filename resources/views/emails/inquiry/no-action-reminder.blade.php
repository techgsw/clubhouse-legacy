@component('emails.layout')
    @slot('body')
        <p>Some of your job postings have applicants that have not been reviewed yet:</p>
        @foreach($jobs as $job)
            @if(!$job->assignments->isEmpty() || !$job->inquiries->isEmpty())
                <h3><a href="{{env('CLUBHOUSE_URL')}}/job/{{$job->id}}">{{$job->title}} at {{$job->organization_name}}</a></h3>
                <ul>
                    @foreach($job->assignments as $assignment)
                        <li>{{$assignment->contact->first_name}} {{$assignment->contact->last_name}} - <a href="mailto:{{$assignment->contact->email}}">{{$assignment->contact->email}}</a></li>
                    @endforeach
                    @foreach($job->inquiries as $inquiry)
                        <li>{{$inquiry->name}} - <a href="mailto:{{$inquiry->email}}">{{$inquiry->email}}</a></li>
                    @endforeach
                </ul>
            @endif
        @endforeach
        <p><a href="{{env('CLUBHOUSE_URL')}}/user/{{$user->id}}/job-postings">Click here to see all of your job postings.</a></p>
    @endslot
@endcomponent
