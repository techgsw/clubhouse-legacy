@component('emails.layout')
    @slot('body')
        <p>Hey {{$user->first_name}},</p>
        <p>We have new job postings that you may be interested in:</p>
        <br>
        <table>
            @foreach ($jobs as $job)
                <tr>
                    @if (!is_null($job->image))
                        <td style="padding-right:20px;padding-bottom:35px;max-width:102px;min-width:70px;">
                            <img src={{ $job->image->getURL('medium') }} class="no-border" width="102">
                        </td>
                    @endif
                    <td style="padding-bottom:35px;">
                        <h1 style="margin-bottom:0px;">{{$job->title}}</h1>
                        <strong>{{$job->organization_name}}</strong> in {{$job->city}}, {{$job->state}}, {{$job->country}}
                        @if ($job->tags)
                            <div style="margin-top:10px;">
                                <i style="font-size: .9em">
                                    {{ $job->tags->implode('name', ', ') }}
                                </i>
                            </div>
                        @endif
                        <a href="{{env('CLUBHOUSE_URL').$job->getURL()}}">Click here to apply</a>
                    </td>
                </tr>
            @endforeach
        </table>
        <p>We sent you this message based on your sports job interests and preferences. If you'd like to update them, or opt out of these emails, click <strong>"Opt out of all new job posting emails"</strong> under <strong>"Email Preferences"</strong> in your <a href="{{env('CLUBHOUSE_URL')}}/user/{{$user->id}}/edit-profile">profile</a>.</p>
        <p>Thanks, <br/><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
    @endslot
@endcomponent


