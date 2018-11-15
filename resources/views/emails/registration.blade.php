@component('emails.layout')
    @slot ('title')
        Welcome to <span style="color: #EB2935;">the</span>Clubhouse
    @endslot
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>I’m Bob Hamer, former Vice President at the Phoenix Suns, current President and Founder of Sports Business Solutions, and creator of <span style="color: #EB2935;">the</span>Clubhouse. We’re so excited to have you as part of our community! Our goal for <span style="color: #EB2935;">the</span>Clubhouse is to create a destination for current and aspiring sports business professionals where they can network, learn, and share industry best practices in an effort to grow their career and elevate the sports industry as a whole.</p>
        <p>Now that you’re a member of our community, here are some ways you can get the most out of <span style="color: #EB2935;">the</span>Clubhouse:</p>
        <p>
            <ul>
                <li>Complete <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}">your profile</a>. Upload your resume and your career preferences, so you can connect with the right people and be kept in mind for career opportunities down the road.</li>
                <li>Head over to the <a href="{{ env('CLUBHOUSE_URL') }}/job">Job Board</a> if you’re interested in looking for a new job in sports!</li>
                <li>Browse our <a href="{{ env('CLUBHOUSE_URL') }}/carrer-services">Career Services</a>. Our team has been successful in sports and they can help you pave a path to industry success.</li>
            </ul>
        </p>
        <p>At anytime you can choose to <a href="{{ env('CLUBHOUSE_URL') }}">become a Clubhouse Pro</a>, and your <strong>free 30-day trial</strong> will unlock a number of more personalized and immersive opportunities for you!  You’ll have exclusive access to industry pros, private events, and discounts including:</p>
        <p>
            <ul>
                <li>1:1 mentorship where you can set up time to chat with sports industry professionals directly.</li>
                <li>Access to private events and sports industry “meet-ups” in your local communities.</li>
                <li>All of our live webinar discussions led by panelists from across the sports business community.</li>
                <li>50% off of all career services.</li>
                <li>Coming soon! - Gain access to hands on sports team projects to bolster your resume.</li>
            </ul>
        </p>
        <p>We started <span style="color: #EB2935;">the</span>Clubhouse to give our community members the edge they need to accomplish their goals in sports business. If you have ideas for other ways we can help you do that, feel free to email us. Your input will be valuable in shaping the future of this industry.</p>
        <p>Thanks,<br/><span style="color: #EB2935;">the</span>Clubhouse Team</p>
    @endslot
@endcomponent
