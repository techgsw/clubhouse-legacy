@component('emails.layout')
    @slot ('title')
        Welcome to <span style="color: #EB2935;">the</span>Clubhouse
    @endslot
    @slot('body')
        <p>Hi {{ ucwords($user->first_name) }},</p>
        <p>My name is Bob Hamer and I’m the President and Founder of Sports Business Solutions and creator of <span style="color: #EB2935;">the</span>Clubhouse. We’re excited to have you as part of our community!</p>
        <p>Our goal for <span style="color: #EB2935;">the</span>Clubhouse is to create a destination for current and aspiring sports business professionals where they can find the resources and connections they need to succeed in the industry.</p>
        <p>Now that you’re a member, here are some ways you can get the most out of <span style="color: #EB2935;">the</span>Clubhouse experience:</p>
        <p>
            <ul>
                <li>Complete your <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}">your profile</a>. Upload your resume and career preferences, so you can connect with the right people and be kept in mind for career opportunities down the road.</li>
                <li>Head over to the <a href="{{ env('CLUBHOUSE_URL') }}/job">Job Board</a> if you’re interested in looking for a new job in sports, or <a href="{{ env('CLUBHOUSE_URL') }}/user/{{ $user->id }}/job-postings">post a job</a> if you’re a hiring manager.</li>
                <li>Check out our sports industry <a href="{{ env('CLUBHOUSE_URL') }}/blog">Blog</a> and upcoming <a href="{{ env('CLUBHOUSE_URL') }}/webinars">Webinars</a> where you can learn from some of the best in the business.</li>
            </ul>
        </p>
        <p>At any time you can choose to become a <a href="{{ env('CLUBHOUSE_URL') }}/membership-options">Clubhouse Pro</a>, and your free 30-day trial will unlock a number of more personalized opportunities! Included will be:</p>
        <p>
            <ul>
                <li>1:1 mentorship where you can set up time to chat with sports industry professionals.</li>
                <li>Access to our library of past webinars and video content.</li>
                <li>Free career services.</li>
            </ul>
        </p>
        <p>Our mission in <span style="color: #EB2935;">the</span>Clubhouse is to help more people like you succeed in sports. Hope you find the experience to be valuable! See you in <span style="color: #EB2935;">the</span>Clubhouse...</p>
        <p>-Bob</p>
    @endslot
@endcomponent
