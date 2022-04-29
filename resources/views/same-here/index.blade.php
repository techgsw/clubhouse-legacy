@php $pd = new Parsedown(); @endphp
@extends('layouts.clubhouse')
@section('title', '#SameHere Solutions')
@section('content')
    <div class="container" style="margin-bottom:75px;">
        <div class="row" style="padding:40px 0px 0px 0px;">
            <div class="col s12 m10 offset-m1 center-align">
                <img src="/images/same-here/same-here-color.png">
            </div>
        </div>
        <div class="row" style="padding:40px 0px;">
            <div class="col s12 m10 offset-m1 center-align">
                <h4><strong>As sports industry professionals we all face challenges that can affect our mental health.</strong></h4>
            </div>
            <div class="col s12 center-align">
                <p>This is THE destination for those of us in sports business, at all levels, to talk about those challenges and get the support we need to persevere. Whether it's in your career or your personal life, everyone is going through something. By joining this community we will provide you with resources, peer-to-peer support, and even recommendations to ensure you're staying healthy both in and out of the front office.</p>
            </div>
        </div>
        <div class="row gray-bg" style="padding: 30px 30px;">
            <div class="col s12 m6">
                <h5><strong>What's our why?</strong></h5>
                <p>Each of us on theClubhouse® team are excited to continue the collaboration with our friend Eric Kussin, Founder of the non-profit We’re All a Little “Crazy” and creator of the #SameHere Global Mental Health Movement.</p>
                <p>As a group we have 70+ years of experience in the sports industry and have each faced mental health challenges both personally and professionally, and are looking forward to sharing our stories, strategies, and resources in an effort to help others.</p>
                <a target="_blank" href="https://www.linkedin.com/company/the-clubhouse-gsw"><img src="/images/linkedin-bw.png" style="max-width: 20px; border-bottom: none;" /> The Clubhouse</a>
                <br />
                <a target="_blank" href="https://www.linkedin.com/company/we-are-all-a-little-crazy/"><img src="/images/linkedin-bw.png" style="max-width: 20px; border-bottom: none;" />#Same Here</a>
            </div>
            <div class="col s12 m6 center-align">
                <div class="col s6 center-align">
                    <a href="/blog/eric-kussin--my-samehere-story" class="no-underline">
                        <a class="no-underline" href="https://www.linkedin.com/in/eric-kussin-5010a37/" target="_blank"><img src="/images/same-here/eric-same-here-cropped.jpg" style="width: 80%; max-width: 180px; border-radius: 50%;"></a>
                        <h5>
                            Eric Kussin
                            <span class="about-position">CEO & Founder</span>
                            <span class="about-position sbs-red-text">We're All A Little "Crazy":</span>
                        </h5>
                    </a>
                </div>
                <div class="col s6 center-align">
                    <a href="https://www.linkedin.com/in/lou-depaoli-3a41595/" target="_blank" class="no-underline"><img src="/images/same-here/lou-de-paoli.png" style="width: 80%; max-width: 180px; border-radius: 50%;"></a>
                    <h5>
                        Lou De Paoli 
                        <span class="about-position">Managing Director</span>
                        <span class="about-position sbs-red-text">General Sports Worldwide</span>
                    </h5>
                </div>
                <div class="col s6 center-align">
                    <a href="https://www.linkedin.com/in/travisapple/" target="_blank" class="no-underline"><img src="/images/same-here/travis-apple.png" style="width: 80%; max-width: 180px; border-radius: 50%;"></a>
                    <h5>
                        Travis Apple
                        <span class="about-position">Vice President</span>
                        <span class="about-position sbs-red-text">General Sports Worldwide</span>
                    </h5>
                </div>
                <div class="col s6 center-align">
                    <a href="https://www.linkedin.com/in/jentrymullins/" target="_blank" class="no-underline"><img src="/images/same-here/jentry-mullins.png" style="width: 80%; max-width: 180px; border-radius: 50%;"></a>
                    <h5>
                        Jentry Mullins 
                        <span class="about-position">Senior Director</span>
                        <span class="about-position sbs-red-text">General Sports Worldwide</span>
                    </h5>
                </div>
                <div class="col s6 center-align">
                    <a href="https://www.linkedin.com/in/kayla-lawson4/" target="_blank" class="no-underline"><img src="/images/same-here/kayla-lawson.png" style="width: 80%; max-width: 180px; border-radius: 50%;"></a>
                    <h5>
                        Kayla Lawson
                        <span class="about-position">Manager</span>
                        <span class="about-position sbs-red-text">General Sports Worldwide</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div id="same-here-blog" class="container-fluid gray-bg">
        <div class="container" style="padding:40px 0px;">
            <div class="row">
                <div class="col s12 center-align">
                    <h4>#SameHere Solutions Blog</h4>
                    <p>This blog is filled with personal stories and "life hacks" to help support your mental health. It can be intimidating but incredibly rewarding to tell your story. If you'd like to take that step, we'd be honored if you told your story here. If interested, <a href="mailto:theclubhouse@generalsports.com">message us</a>.</p>
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
    <div id="same-here-webinars" class="container" style="padding:40px 0px;">
        <div class="row">
            <div class="col s12 center-align">
                <h4>Mental Health Discussions</h4>
                <p>The mission of #SameHere Solutions is to help those in the sports business who are facing challenges of any severity, to get the support and resources they need to ultimately thrive both in and out of the office. These sessions are live and interactive and if you want to hear from others that may have the same challenges you do, you should join us. Attendance can be anonymous among other attendees.</p>
            </div>
        </div>
        <div class="row center-align valign-wrapper" style="margin-bottom: 0;">
            <div class="col s12">
                <h4 id="upcoming" style="font-weight: bold; text-align: center;">UPCOMING WEBINAR EVENTS</h4>
            </div>
            @if (count($active_webinars) > 0)
                @foreach ($active_webinars as $webinar)
                    @if ($loop->index % 2 == 0)
                        </div>
                        <div class="row center-align">
                            <div class="col m1 hide-on-small-and-down"></div>
                    @endif
                    <div class="col s12 m5">
                        @include('product.webinars.components.list-item', ['product' => $webinar])
                    </div>
                @endforeach
            @else
                </div>
                <div class="row center-align">
                    <div class="col s12 center-align">
                        <h4>Coming soon.</h4>
                    </div>
            @endif
        </div>
        @if (count($inactive_webinars) > 0)
            <hr class="sbs-red" style="color: #EB2935;" />
            <div class="row">
                <div class="row center-align valign-wrapper" style="margin-bottom: 0;">
                    <div class="col s12">
                        <h4 id="past" style="font-weight: bold; text-align: center;">PAST WEBINAR EVENTS</h4>
                    </div>
                </div>
                <div class="row" style="max-width: 800px;margin-right:auto;margin-left:auto;">
                    @foreach ($inactive_webinars as $webinar)
                        @include('product.webinars.components.inactive-list-item', ['product' => $webinar])
                    @endforeach
                </div>
            </div>
        @endif
        <div class="row" style="margin-bottom: 0;">
            <div class="col s12 center-align" style="padding-bottom: 50px;">
                <a href="/webinars?tag=%23samehere" class="btn sbs-red" style="margin-top: 20px;">See all past events</a>
            </div>
        </div>
    </div>
@endsection
