@component('emails.layout')
    @slot('body')
        <p>{{$contact_job->contact->first_name}},</p>
        <p>Thanks for being a part of <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> community!</p>
        <p>More and more hiring managers are using <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> to find the next sports business superstar to join their team, and today, we have some exciting news for you!</p>
        <p>Based on your work experience and qualifications the <strong>{{ $contact_job->job->organization_name }}</strong> want to consider you for an open job on their team.</p>
        <p>Are you interested in having a conversation to learn more?</p>
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
        <p>We aren’t sure of your job status but please let us know either way when you can. We’ll refrain from moving on until we hear back from you, thanks!</p>
        <p>-<span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> Team</p>
        <br />
        <p style="font-size: 10px; color: grey;">Don't want to hear from us again? Let us know by <a href="{{ env('CLUBHOUSE_URL') }}/contact/feedback/{{ $contact_job->id }}?interest=do-not-contact&token={{ $contact_job->job_interest_token }}">clicking here</a></p>
    @endslot
@endcomponent
