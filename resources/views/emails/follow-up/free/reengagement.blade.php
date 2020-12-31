@component('emails.layout')
    @slot ('title')
        We miss you!
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>We haven’t seen you for a while, and we miss you!</p>
        <p>There are always new things happening in <span style="color: #EB2935;">the</span>Clubhouse. Login and check them out <a href="{{ env('CLUBHOUSE_URL') }}/login">here</a>.</p>
        <p>Have you updated your <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">career profile</a>? If not, please do, so we can get you more of the info you want.</p>
        <p>Bored with the FREE services and want something more expansive and customized? Check out <a href="{{ env('CLUBHOUSE_URL') }}/pro-membership">Clubhouse PRO membership</a>.</p>
        <p>Have some feedback for us? Has something changed on your end? Let us know by emailing us here: <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a></p>
        <p>Hope to see you back in <span style="color: #EB2935;">the</span>Clubhouse soon!</p>
        @include('emails.signature-footer')
    @endslot
@endcomponent
