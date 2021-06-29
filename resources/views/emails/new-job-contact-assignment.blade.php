@component('emails.layout')
    @slot('body')
        <p>{{$user->first_name}},</p>
        <p>{{$contact_job->contact->first_name}} {{$contact_job->contact->last_name}} has been assigned as a new candidate for the following posting:</p>
        <br>
        <table>
            <tr>
                @if (!is_null($job->image))
                    <td style="padding-right:20px;padding-bottom:35px;">
                        <img src={{ $job->image->getURL('medium') }} class="no-border" width="102">
                    </td>
                @endif
                <td style="padding-bottom:35px;">
                    <h1 style="margin-bottom:0px;">{{$job->title}}</h1>
                    <strong>{{$job->organization_name}}</strong> in {{$job->city}}, {{$job->state}}, {{$job->country}}
                </td>
            </tr>
        </table>
        <a href="{{env('CLUBHOUSE_URL').$job->getURL()}}">Click here to reach out to them!</a>
        <br>
        <p>-<span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
    @endslot
@endcomponent
