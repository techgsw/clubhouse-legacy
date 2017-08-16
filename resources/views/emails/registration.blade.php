@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Thank you for joining the Sports Business Solutions community! You’re now part of a group of current and aspiring sports industry professionals who are committed to success in sports business. Congratulations on taking this step in your career!</p>
        <p>Now that you're a member, what's next?</p>
        <ul>
            <li>Go to the <a href="{{ config('app.url') }}job">Job Board</a> to search for job opportunities. As a member, you can apply and take the first step toward landing the perfect job.</li>
            <li>Visit the <a href="{{ config('app.url') }}question">Forum</a>, where our community members ask and answer the questions that matter to you. As a member, you can ask and answer questions.</li>
            <li>View <a href="{{ config('app.url') }}user/{{ $user->id }}">your profile</a> and update it when you land that job!</li>
        </ul>
        <p>Regards,<br/>Sports Business Solutions</p>
    @endslot
@endcomponent
