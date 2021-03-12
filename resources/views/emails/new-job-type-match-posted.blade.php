@component('emails.layout')
    @slot('body')
        <p>Hey {{$user->first_name}},</p>
        <p>We have a new job posting that you may be interested in:</p>
        <table>
            <tr>
                @if (!is_null($job->image))
                    <td style="width:25%;padding-right:20px;">
                        <img src={{ $job->image->getURL('medium') }} class="no-border">
                    </td>
                @endif
                <td>
                    <h1 style="margin-bottom:0px;">{{$job->title}}</h1>
                    <strong>{{$job->organization_name}}</strong> in {{$job->city}}, {{$job->state}}, {{$job->country}}
                </td>
            </tr>
        </table>
        <br>
        <a href="{{env('CLUBHOUSE_URL').$job->getURL()}}">Click here to apply</a>
        <br><br>
        <p>We sent you this message based on your sports job interests and preferences. If you'd like to update them, or opt out of these emails, <a href="{{env('CLUBHOUSE_URL')}}/user/{{$user->id}}/edit-profile">edit your profile here</a>.</p>
        <p>Thanks, <br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent


