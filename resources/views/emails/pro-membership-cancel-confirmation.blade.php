@component('emails.layout')
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>We're sad to see you go, but thanks for giving us a try!</p>
        <p>This email is a confirmation of your Clubhouse PRO membership cancellation. You will no longer get your PRO member benefits and won't be charged anything additionally.</p>
        <p>If you'd like to add PRO membership in the future, you can do so at any time by going <a href="{{ env('CLUBHOUSE_URL') }}/pro-membership">here</a>. Hope to see you back in <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup> soon!</p>
        @include('emails.signature-footer')
    @endslot
@endcomponent
