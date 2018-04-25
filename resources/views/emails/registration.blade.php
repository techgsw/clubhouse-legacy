@component('emails.layout')
    @slot ('title')
        Welcome to Sports Business Solutions
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Welcome to the Sports Business Solutions community. You’ve joined a group of current and aspiring sports business professionals who are committed to succeeding in the sports industry. Congratulations!</p>
        <p>Now that you're a member, what's next?</p>
        <p>
            <ul>
                <li>Update <a href="{{ config('app.url') }}/user/{{ $user->id }}">your profile</a>. Upload your resume and add your information so we can get to know your better. If you’re interested, we can also keep you in mind for future job opportunities in sports.</li>
                <li>Visit our <a href="{{ config('app.url') }}question">Q&A Forum</a>. Here you can pose questions to our community and they can respond and share best practices and advice.</li>
                <li>Looking for a job in sports right now? Check out our <a href="{{ config('app.url') }}job">Job Board</a> and see open positions.</li>
            </ul>
        </p>
        <p>Regards,<br/>Sports Business Solutions</p>
    @endslot
@endcomponent
