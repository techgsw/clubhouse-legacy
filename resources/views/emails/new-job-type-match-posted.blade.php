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
        <p>Thanks, <br/><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
        <br>
        <p style="font-size:.9em;text-align:center;">
            <a href="{{env('CLUBHOUSE_URL')}}/user/self/edit-profile">Change which jobs you'd like to hear about</a>
        </p>
        @include('emails.footer-manage-preferences', ['user' => $user])
    @endslot
@endcomponent


