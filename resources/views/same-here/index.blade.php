@extends('layouts.same-here')
@section('title', '#SameHere Solutions')
@section('hero')
    <div class="row hero bg-image same-here">
        <div class="col s12">
            <img src="/images/same-here/logo.png" style="max-width:200px;">
        </div>
        <div class="col s12">
            <h2 class="header">We're all in this together.</h2>
            <br>
            <a href="#same-here-newsletter" class="flat-button btn-large same-here white" style="max-width: 250px;">Join our community</a>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row" style="padding:40px 0px;">
            <div class="col s12 center-align">
                <h4><strong>As sports industry professionals we all face challenges that can affect our mental health.</strong></h4>
            </div>
            <div class="col s12 center-align">
                <p>This is THE destination for those of us in sports business, at all levels, to talk about those challenges and get the support we need to persevere. Whether it's in your career or your personal life, everyone is going through something. By joining this community we will provide you with resources, peer-to-peer support, and even recommendations to ensure you're staying healthy both in and out of the front office.</p>
            </div>
        </div>
        <div class="row gray-bg" style="padding: 30px 30px;">
            <div class="col s12 m6">
                <h5><strong>What's our why?</strong></h5>
                <p>This is a collaboration between me (Bob Hamer the President & Founder of Sports Business Solutions) and my great friend and mentor (Eric Kussin, the Founder of the Non Profit We're All a Little "Crazy" and creator of the #SameHere Global Mental Health Movement).</p>
                <p>Together we have more than 30 years of experience in sports business. We worked together at the Phoenix Suns and we both have faced mental health challenges. Our vision is to share stories, strategies, and resources in an effort to help others in sports overcome the challenges we all face at some point or another.</p>
            </div>
            <div class="col s6 m3 center-align">
                <a href="/blog/bob-hamer--my-battle-with-ocd" class="no-underline">
                    <img src="/images/same-here/bob-same-here.jpg" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5>
                        Bob Hamer
                        <span class="about-position">President & Founder</span>
                        <span class="about-position sbs-red-text">Sports Business Solutions</span>
                    </h5>
                </a>
            </div>
            <div class="col s6 m3 center-align">
                <a href="/blog/eric-kussin--my-samehere-story" class="no-underline">
                    <img src="/images/same-here/eric-kussin.png" style="width: 80%; max-width: 180px; border-radius: 50%;">
                    <h5>
                        Eric Kussin
                        <span class="about-position">CEO & Founder</span>
                        <span class="about-position sbs-red-text">We're All A Little "Crazy":</span>
                        <span class="about-position">Global Mental Health Alliance&#8482;</span>
                        <span class="about-position">The #SameHere Movement&#8482;</span>
                    </h5>
                </a>
            </div>
        </div>
    </div>
    <br>
    <div class="container-fluid" style="background-color: #EB2935;color: #FFFFFF;">
        @include('same-here.newsletter')
    </div>
    <div class="container" style="padding:40px 0px;">
        <div class="row">
            <div class="col s12 center-align">
                <h4>Mental Health Discussion Board</h4>
                <p>Member or not, feel free to share your thoughts and questions anonymously here.</p>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <form class="form-horizontal" role="form" method="POST" action="/same-here/discussion">
                    {{ csrf_field() }}
                    <div class="input-field col s12 m8">
                        <input id="title" type="text" class="validate {{ $errors->has('title') ? 'invalid' : '' }}" name="title" required>
                        <label for="title" data-error="{{ $errors->first('title') }}">Title</label>
                    </div>
                    <div class="input-field col s12">
                        <textarea id="body" class="materialize-textarea validate {{ $errors->has('body') ? 'invalid' : '' }}" name="body" required></textarea>
                        <label for="body" data-error="{{ $errors->first('body') }}">Something on your mind?</label>
                    </div>
                    <div class="col s12">
                        @include('layouts.components.errors')
                    </div>
                    <div class="col s12">
                        <div class="g-recaptcha" style="transform:scale(0.65);-webkit-transform:scale(0.65);transform-origin:0 0;-webkit-transform-origin:0 0; margin-top: 10px;" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        <button type="submit" class="btn sbs-red">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            @foreach($questions as $question)
                <div class="col s12 m8 offset-m2">
                    <hr>
                    <h6><a href="/same-here/discussion/{{ $question->id }}" class="sbs-red-text">{{ $question->title }}</a></h6>
                    <h6 style="padding:5px 0px;color:#888;">{{ count($question->answers) }} answer{{count($question->answers) == 1 ? '' : 's'}} &#183 <a class="no-underline" href="/same-here/discussion/{{ $question->id }}">View All</a></h6>
                    <p>{{ $question->body }}</p>
                </div>
            @endforeach
            <div class="col s12 m8 offset-m2">
                <br>
                <a href="/same-here/discussion" class="flat-button large red" style="">Load More</a>
            </div>
        </div>
    </div>
    <div class="container-fluid gray-bg">
        <div class="container" style="padding:40px 0px;">
            <div class="row">
                <div class="col s12 center-align">
                    <h4>#SameHere Solutions Blog</h4>
                    <p>This blog is filled with personal stories and "life hacks" to help support your mental health. It can be intimidating but incredibly rewarding to tell your story. If you'd like to take that step, we'd be honored if you told your story here. If interested, <a href="mailto:clubhouse@sportsbusiness.solutions">message us</a>.</p>
                </div>
            </div>
            <div class="row">
                @if (count($posts) > 0)
                    @foreach ($posts as $post)
                        <div class="col s12 m4" style="padding: 0 30px;">
                            <div class="col s12 about-cards">
                                @if (!is_null($post->images->first()))
                                    <a href="/post/{{ $post->title_url}}" class="no-underline"><img class="img-responsive" style="" src="{{ $post->images->first()->getURL('medium') }}" /></a>
                                @endif
                            </div>
                            <div class="col s12">
                                <h5 style="margin-top: 0; margin-bottom: 10px; display: block;"><a href="/post/{{ $post->title_url}}" class="no-underline">{{$post->title}}</a></h5>
                                <a href="/post/{{ $post->title_url}}" class="sbs-red-text no-underline">READ MORE ></a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col s12 center-align">
                        <h4>Coming soon.</h4>
                    </div>
                @endif
            </div>
            <div class="row" style="margin-bottom: 0;">
                <div class="col s12 center-align" style="padding-bottom: 50px;">
                    <a href="/same-here/blog" class="btn sbs-red" style="margin-top: 20px;">More articles</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="padding:40px 0px;">
        <div class="row">
            <div class="col s12 center-align">
                <h4>Mental Health Discussions</h4>
                <p>The mission of #SameHere Solutions is to help those in the sports business who are struggling, to get the support and resources they need to stay strong both in and out of the office. These sessions are live and interactive and if you want to hear from others that may have the same challenges you do, you should join us. Attendance can be anonymous among other attendees.</p>
            </div>
        </div>
        <div class="row center-align valign-wrapper" style="margin-bottom: 0;">
            <div class="col s2 m4">
                <hr style="border: 1px solid;" />
            </div>
            <div class="col s8 m4">
                <p style="font-size: 20px; color: #9E9E9E;">Upcoming Events</p>
            </div>
            <div class="col s2 m4">
                <hr style="border: 1px solid;" />
            </div>
        </div>
        <div class="row center-align">
            @if (count($webinars) > 0)
                <div class="col m1 hide-on-small-and-down"></div>
                @foreach ($webinars as $index => $webinar)
                    <div class="col s12 m5">
                        @include('same-here.webinars.components.list-item', ['product' => $webinar])
                    </div>
                @endforeach
            @else
                <div class="col s12 center-align">
                    <h4>Coming soon.</h4>
                </div>
            @endif
        </div>
        <div class="row" style="margin-bottom: 0;">
            <div class="col s12 center-align" style="padding-bottom: 50px;">
                <a href="/same-here/webinars" class="btn sbs-red" style="margin-top: 20px;">See all events</a>
            </div>
        </div>
    </div>
    @include('layouts.components.clubhouse.same-here-footer')
@endsection
