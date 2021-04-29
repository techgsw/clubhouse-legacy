@component('emails.layout')
    @slot ('title')
        Have we connected yet?
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Thank you for signing up for PRO membership in <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup></p>
        <p>As mentioned when you signed up, the first step is for us to get to know you better.</p>
        <p>Please be sure to update your <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">career profile</a> so we can tailor the content in <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> to your preferences.</p>
        <p>I’m curious, how have you been enjoying the PRO experience thus far?</p>
        @include('emails.signature-footer')
    @endslot
@endcomponent
