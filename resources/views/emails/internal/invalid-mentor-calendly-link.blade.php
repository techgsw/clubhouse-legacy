@component('emails.layout')
    @slot('body')
        <p>{{count($mentors) == 1 ? 'An active mentor has' : 'Some active mentors have' }} been found with invalid Calend.ly links:</p>
        <ul>
            @foreach ($mentors as $mentor)
                <li><b>{{$mentor->contact->first_name}} {{$mentor->contact->last_name}}:</b> 
                    @if ($mentor->calendly_link)
                        <a href="{{$mentor->calendly_link}}">{{$mentor->calendly_link}}</a>
                    @else
                        No Calend.ly link
                    @endif
                </li>
            @endforeach
        </ul>
        <p><b>NOTE:</b> This script checks all active mentors' Calend.ly page for the text "is not valid". If you notice any of these pages are in fact valid, please let the developers know along with the valid link.</p>
        <p>If there are a ton of links in this message, it's possible that Calend.ly or a service is/was down. Developers can run this script again or investigate. (ask them to run <code>php artisan email:checkcalendlylinks</code>)</p>
        <p>-<span style="color:#EB2935">the</span>Clubhouse<sup>&#174;</sup> Team</p>
    @endslot
@endcomponent


