@component('emails.layout')
    @slot('body')
        <p>Here are the following statistics from the last {{$days_since}} days:</p>
        <ul>
            <li><b>Total Requests:</b> {{$total_requests}}</li>
            <li><b>Count of Requests by Mentor:</b>
                <ul>
                    @foreach ($mentors as $mentor)
                        <li><b>{{$mentor->contact->first_name}} {{$mentor->contact->last_name}}:</b> {{count($mentor->mentorRequests)}}</li>
                    @endforeach
                </ul>
            </li>
            <li><b>Count of Requests by Mentee:</b>
                <ul>
                    @foreach ($mentees as $mentee)
                        <li><b>{{$mentee->first_name}} {{$mentee->last_name}}:</b> {{count($mentee->mentorRequests)}}</li>
                    @endforeach
                </ul>
            </li>
        </ul>
        <p>-<span style="color:#EB2935">the</span>Clubhouse Team</p>
    @endslot
@endcomponent

