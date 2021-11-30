@component('emails.layout')
    @slot ('title')
        Maximize your Clubhouse experience
    @endslot
    @slot('body')
        <p>{{ ucwords($user->first_name) }},</p>
        <p>Each week there’s new content in <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup>. The goal? To share insight and best practices to help you succeed.</p>
        <p>What are some examples?</p>
        <ul>
            <li><a href="{{ env('CLUBHOUSE_URL') }}/blog?tag=%23mysportsbizstart">#MySportsBizStart</a> – You’ll find this in the <a href="{{ env('CLUBHOUSE_URL') }}/blog">blog</a>. Industry leaders share how they got their start</li>
            <li><a href="{{ env('CLUBHOUSE_URL') }}/blog?tag=%23samehere">#SameHere</a> Stories – Industry professionals (including me) share their struggles with mental health in sports and how they continue to overcome it</li>
            <li>Webinars – The same speakers you see at conferences are giving the same advice on our webinars, and it’s free to attend! See upcoming <a href="{{ env('CLUBHOUSE_URL') }}/webinars">events</a></li>
            <li>The Sales Vault – We constantly share new videos for you salespeople out there to brush up on your technique. <a href="{{ env('CLUBHOUSE_URL') }}/sales-vault">See new videos</a></li>
        </ul> 
        <p>Interested in more content and 1:1 career coaching and support? Upgrade to <a href="{{ env('CLUBHOUSE_URL') }}/pro-membership">PRO membership</a></p>
        <p>Also, don’t forget to update your <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/profile">career profile</a> so we can get you more of the content you want.</p>
        @include('emails.signature-footer')
        @include('emails.footer-manage-preferences', ['user' => $user])
    @endslot
@endcomponent

