@extends('layouts.clubhouse')
@section('title', 'Sports Industry Resource')
@section('hero')
    <div class="row hero bg-image clubhouse">
        <div class="container">
            <div class="row">
                <div class="col m6">
                    <h4 class="" style="margin-top: 0; font-weight: 300;">Welcome to theClubhouse!</h4>
                    <h5><i>THE sports business community</i></h5>
                    <p>theClubhouse is a place where current and aspiring sports business professionals go to learn, network, browse career opportunities and share best practices in an effort to grow their career in sports.</p>
                    <p>Whether you want to connect with industry pros, you have a desire to give back, or you’re looking for a job in sports, we’re confident this platform is your ticket to sports industry success.</p>
                </div>
                <div class="col m6" style="position: relative;">
                    <div class="fill-grey hide-on-small-only" style="position: absolute; top: -40px; width: 100%;">
                            <img src="/images/clubhouse/medal.png" style="float: right; max-width: 100px; margin-top: 20px; margin-right: 40px; padding-right: 20px;" />
                        @if (Auth::guest())
                            <p class="header font-black" style="font-size: 24px; margin-bottom: 0; margin-top: 40px; margin-left: 20px;"><strong>Join for free!</strong></p>
                            <p class="font-black" style="margin-top: 0; margin-left: 20px; font-size: 12px;"><a class="no-underline" href="/login">Already a member? Login!</a></p>
                            <div id="registration-form-wrapper-top" style="padding-left: 20px; padding-right: 20px;">
                                @include('components.register-clubhouse')
                            </div>
                        @else
                            <div style="padding: 25px">
                                @can ('view-clubhouse')
                                    <h5 class="black-text" style="margin-top: 20px">Thanks for being a Clubhouse Pro!</h5>
                                    <p class="black-text">Make the most out of your premium membership by completing your profile, talking with industry professionals and participating in our live webinars.</p>
                                    <div class="col s6 center-align">
                                        <a href="/mentor" class="no-underline">
                                            <img class="" style="width: 100px; margin-top: 0px;" src="/images/clubhouse/mentorship.png" />
                                            <h5 class="black-text" style="margin-top: 0;">Mentors</h5>
                                        </a>
                                    </div>
                                    <div class="col s6 center-align">
                                        <a href="/webinars" class="no-underline">
                                            <img class="" style="width: 100px; margin-top: 0px;" src="/images/clubhouse/event.png" />
                                            <h5 class="black-text" style="margin-top: 0;">Webinars</h5>
                                        </a>
                                    </div>
                                    <div class="col s12 center-align">
                                        <a href="/user/{{ Auth::user()->id }}/edit-profile" class="btn sbs-red" style="margin-top: 20px; margin-bottom: 20px;"> My Profile</a>
                                    </div>
                                @else
                                    <h5 class="black-text" style="margin-top: 20px;">We're glad you're here!</h5>
                                    <p class="black-text">As a member of our community you can access the <a href="/blog">blog</a>, search and apply for jobs on the <a href="/job">job board</a> and join us for an upcoming live <a href="/webinars">webinar</a>. If you’re a hiring manager, you can also <a href="/user/{{ Auth::user()->id }}/job-postings">post your job</a>.</p>
                                    <p class="black-text">If you’re interested in getting even more access you can upgrade your membership to become a Clubhouse Pro! Benefits include:</p>
                                    <ul class="browser-default">
                                        <li>Exclusive 1:1 mentorship with industry professionals</li>
                                        <li>Access to our virtual library of educational content</li>
                                        <li>Free career services</li>
                                    </ul>
                                    <div class="center-align">
                                        <a href="/pro-membership" class="btn sbs-red" style="margin-top: 20px;"> Become a Clubhouse Pro</a>
                                    </div>
                                @endcan
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row show-on-small hidden">
            <div class="col s12">
                @if (Auth::guest())
                    <img src="/images/clubhouse/medal.png" style="float: right; margin-top: 20px;" />
                    <p class="header font-black" style="font-size: 24px; margin-top: 40px; margin-left: 20px;"><strong>Ready to join?</strong></p>
                    <p class="font-black" style="margin-top: 0; margin-left: 20px; font-size: 12px;"><a class="no-underline" href="/login">Already a member? Login!</a></p>
                    <div id="registration-form-wrapper-bottom"></div>
                @endif
            </div>
        </div>
        <div class="row">
            <div id="clubhouse-title-text" class="col s12 center-align">
                <h2>Where the sports industry goes to <span><strong><u id="rotating-word">learn</u></strong></span>.<h2>
                <hr class="sbs-red" style="color: #EB2935;" />
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 center-align">
                <a href="/blog" class="no-underline">
                    <img class="" style="width: 100px; margin-top: 50px;" src="/images/clubhouse/digital-marketing.png" />
                    <h3>Sports Industry Blog</h3>
                </a>
            </div>
        </div>
        <div class="row clubhouse-blog">
            @if (count($posts) > 0)
                @foreach ($posts as $post)
                    <div class="col s12 m4" style="padding: 0 30px;">
                        <div class="col s12 about-cards">
                            @if (!is_null($post->images->first()))
                                <a href="/post/{{ $post->title_url}}" class="no-underline"><img class="img-responsive" style="" src="{{ $post->images->first()->getURL('medium') }}" /></a>
                            @endif
                        </div>
                        <div class="col s12">
                            <h5 style="margin-top: 0; margin-bottom: 10px; display: block;"><a href="/post/{{ $post->title_url }}" class="no-underline">{{ $post->title }}</a></h5>
                            <a href="/post/{{ $post->title_url }}" class="sbs-red-text no-underline">READ MORE ></a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        <div class="row">
            <div class="col s12 center-align">
                <a href="/blog" class="btn sbs-red" style="margin-top: 20px;"> More articles</a>
            </div>
        </div>
    </div>
    <div class="fill-grey">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <a href="/mentor" class="no-underline">
                        <img class="" style="width: 100px; margin-top: 50px;" src="/images/clubhouse/mentorship.png" />
                        <h3>Sports Industry Mentors</h3>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="carousel carousel-slider center" data-indicators="true" style="height: 400px;">
                        @if (count($mentors) > 0)
                            @foreach ($mentors as $index => $mentor)
                                @if ($index % 2 == 0)
                                    <div class="carousel-item" style="min-height: 400px;" href="#">
                                        <div class="row">
                                @endif
                                <div class="col s6">
                                    <div class="col m5">
                                        @if ($mentor->contact->headshotImage)
                                            <img src="{{ $mentor->contact->headshotImage->getURL('medium') }}" class="responsive-img circle"/>
                                        @elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
                                            <img src="{{ $mentor->contact->user->profile->headshotImage->getURL('medium') }}" class="responsive-img circle" />
                                        @else
                                            <i class="fa fa-user fa-2x"></i>
                                        @endif
                                    </div>
                                    <div class="col m7 left-align" style="">
                                        <h4 style="margin-bottom: 0px;"><a class="no-underline">{{ $mentor->contact->getName() }}</a></h4>
                                        <p style="margin-top: 0px; margin-bottom: 0px;"><strong>{{ $mentor->contact->getTitle() }}</strong></p>
                                        @if ($mentor->contact->organizations()->first())
                                            @if (!is_null($mentor->contact->organizations()->first()->image))
                                                <div class="col s12 m6" style="padding-left: 0;">
                                                    <img src="{{ $mentor->contact->organizations()->first()->image->getURL('small') }}" class="responsive-img hide-on-small-only" style="margin-top: 15px;" />
                                                </div>
                                            @endif
                                        @endif
                                        <!--<p style="margin-top: 5px;">{{ $mentor->description }}</p>-->
                                    </div>
                                </div>
                                @if (($index == count($mentors) - 1) || (($index + 1) % 2 == 0)) 
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center-align" style="padding-bottom: 50px;">
                    <a href="/mentor" class="btn sbs-red" style="margin-top: 0px;"> Find your mentor</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col s12 center-align">
                <a href="/job" class="no-underline">
                    <img class="" style="width: 100px; margin-top: 50px;" src="/images/clubhouse/job-board.png" />
                    <h3>Sports Job Board</h3>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="card-flex-container">
            @if (count($jobs) > 0)
                @foreach ($jobs as $index => $job)
                    <div class="card">
                        <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: center;">
                            <a href="/job/{{ $job->id }}" style="flex: 1 0 auto; display: flex; flex-flow: column; justify-content: center;" class="no-underline">
                                <img style="width: 120px; margin: 0 auto;" src="{{ $job->image->getURL('medium') }}" />
                            </a>
                            <div class="col s12 center-align" style="padding: 10px 0 50px 0;">
                                <a href="/job/{{$job->id}}">
                                    <h5>{{ $job->title }}</h5>
                                    <p><span class="heavy">{{ $job->organization_name }}</span> in {{ $job->city }}, {{ $job->state }}, {{ $job->country }}</p>
                                </a>
                                <p><strong>{{ $job->name}}</strong></p>
                                <a href="/job/{{$job->id}}" class="btn sbs-red" style="margin-top: 20px;"> Apply now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col s12 center-align">
                    <h4>Coming soon.</h4>
                </div>
            @endif
            </div>
        </div>
        <div class="row">
            <div class="col s12 center-align" style="padding-bottom: 50px;">
                <a href="/job" class="btn sbs-red" style="margin-top: 20px;"> Browse open jobs</a>
            </div>
        </div>
    </div>
    <div class="fill-grey">
        <div class="container">
            <div class="row">
                <div class="col s12 center-align">
                    <a href="/webinars" class="no-underline">
                        <img class="" style="width: 100px; margin-top: 50px;" src="/images/clubhouse/event.png" />
                        <h3>Educational Webinars</h3>
                    </a>
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
                        @foreach ($webinars as $index => $webinar)
                            <div class="col l6">
                                @include('product.webinars.components.list-item', ['product' => $webinar])
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
                    <a href="/webinars" class="btn sbs-red" style="margin-top: 20px;"> See all webinars</a>
                </div>
            </div>
        </div>
    </div>
    <div class="fill-dark-grey">
        <div class="container" style="padding-top: 50px; padding-bottom: 50px;">
            <div class="row center-align">
                <div class="col s12 m6 border-right">
                    <div class="col s12 m4 offset-m4">
                        <img class="responsive-img" src="/images/clubhouse/career-services.png" />
                    </div>
                    <div class="col s12">
                        <h4>Career Services</h4>
                        <p>Want some 1:1 career coaching? Our team is comprised of former successful industry professionals and they’re committed to helping you any way that they can.</p>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="col s12 m4 offset-m4">
                        <img class="responsive-img" src="/images/clubhouse/resources.png" />
                    </div>
                    <div class="col s12">
                        <h4>Resources</h4>
                        <p>There are some things out there that have helped us achieve success in sports and we wanted to share them with all of you too!</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <div class="col s12 center-align" style="padding-bottom: 50px;">
                        <a href="/career-services" class="btn sbs-red" style=""> Browse career services</a>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="col s12 center-align" style="padding-bottom: 50px;">
                        <a href="/resources" class="btn sbs-red" style=""> Sports industry resources</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
