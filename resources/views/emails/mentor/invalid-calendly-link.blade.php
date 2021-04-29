@component('emails.layout')
    @slot('body')
        @if ($mentor->calendly_link)
            <p>We're having trouble getting your mentor Calend.ly link to load. Please double check that this link is written correctly and, if not, <a href="{{env('CLUBHOUSE_URL')}}/contact/{{$mentor->contact->id}}/mentor">edit your mentor profile</a> with the correct link.</p>
            <p><a href="{{$mentor->calendly_link}}">{{$mentor->calendly_link}}</a></p>
            <p>This email is automatically sent if we find any broken links. If this link is working for you then there may have been an issue with Calend.ly that has already been fixed. If you're not sure why the link isn't working then contact us for assistance.</p>
        @else
            <p>It looks like you do not currently have a Calend.ly link set up in your profile. Please <a href="{{env('CLUBHOUSE_URL')}}/contact/{{$mentor->contact->id}}/mentor">edit your mentor profile</a> and add a link to your Calend.ly page. If you need help setting this up or you feel you received this message in error, please contact us for assistance.</p>
        @endif
        <p>-<span style="color:#EB2935">the</span>Clubhouse<sup>&#174;</sup> Team</p>
    @endslot
@endcomponent



