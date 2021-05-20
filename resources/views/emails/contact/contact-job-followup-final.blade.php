@component('emails.layout')
    @slot('body')
        <p>{{$contact_job->contact->first_name}},</p>
        <p>We thought we'd try you one more time.</p>
        <p><strong>{{ $contact_job->job->organization_name }}</strong> is hiring and they're interested in having a conversation with you about an open role on their team. Are you interested in taking an exploratory call with them?.</p>
        <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <table border="0" cellspacing="20" cellpadding="0" align="center">
                        <tr>
                            <td bgcolor="#EB2935" style="padding: 12px 18px 12px 18px; border-radius: 2px;" align="center">
                                <a href="{{ env('CLUBHOUSE_URL') }}/contact/feedback/{{ $contact_job->id }}?interest=interested&token={{ $contact_job->job_interest_token }}" style="text-decoration:none;display:inline-block;color:#FFF;">
                                    <strong>Yes</strong>
                                </a>
                            </td>
                            <td bgcolor="#EB2935" style="padding: 12px 18px 12px 18px; border-radius: 2px;" align="center">
                                <a href="{{ env('CLUBHOUSE_URL') }}/contact/feedback/{{ $contact_job->id }}?interest=not-interested&token={{ $contact_job->job_interest_token }}" style="text-decoration:none;display:inline-block;color:#FFF;">
                                    <strong>No</strong>
                                </a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p>This will be the final time we reach out regarding this opportunity. If we don't hear back this time, we'll assume you're not interested in having a conversation with them.</p>
        <p>-<span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
        <br />
        <p style="font-size: 10px; color: grey;">Don't want to hear from us again? Let us know by <a href="{{ env('CLUBHOUSE_URL') }}/contact/feedback/{{ $contact_job->id }}?interest=do-not-contact&token={{ $contact_job->job_interest_token }}">clicking here</a></p>
    @endslot
@endcomponent



