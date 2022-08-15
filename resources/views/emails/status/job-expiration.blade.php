@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Thank you for posting your job on <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> job board!  We hope the process has been smooth and you've been able to connect with some quality candidates. If for some reason you haven't been able to identify the right fit for the job, you are welcome to extend your listing for another 30 days on the job board for FREE.</p>
        <p>If that isn’t of interest, we hope that you come back to post your open jobs with us again in the future.</p>
        <p>If you have any questions for <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> and SBS team, feel free to reach out anytime at <a href="mailto:{{ __('email.info_address') }}">{{ __('email.info_address') }}</a>. Thanks again and hope to hear from you soon!</p>
        <p>Regards,<br/>{{ __('general.team_name') }}</p>
    @endslot
@endcomponent
