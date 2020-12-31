@component('emails.layout')
    @slot ('title')
        Welcome to <span style="color: #EB2935;">the</span>Clubhouse
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Welcome to <span style="color: #EB2935;">the</span>Clubhouse community, we’re glad you’re here!</p>
        <p><span style="color: #EB2935;">the</span>Clubhouse is the largest and most engaged #sportsbiz community around. With more than 10,000 members, you’re now part of a group that’s committed to learning, growing and being successful in the sports business.</p>
        <p><i>What should you do now?</i> For starters, go <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">here</a> and update your career profile. This is FREE and will help us get you more of the information you want in the future.</p>
        <p>If you’d like to take your sports business career to the next level, check out <a href="{{ env('CLUBHOUSE_URL') }}/pro-membership">Clubhouse PRO</a> membership.</p>
        <p>We look forward to seeing you in <span style="color: #EB2935;">the</span>Clubhouse again soon.</p>
        @include('emails.signature-footer')
    @endslot
@endcomponent
