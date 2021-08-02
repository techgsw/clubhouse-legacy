@component('emails.layout')
    @slot('body')
        <p>Hey {{$user->first_name}},</p>
        @if ($user->can('view-clubhouse'))
            <p>Thank you for being a Clubhouse PRO member! Check out our new content and be sure to take advantage of your membership below.</p>
        @else
            <p>Thank you for being a part of theClubhouse® community! There is exciting new content in theClubhouse®, check it out below.</p>
        @endif
        @if ($user->profile->email_preference_new_content_webinars && $new_webinars->isNotEmpty())
            <h1 class="section-title">New Webinars</h1>
            @if ($user->can('view-clubhouse'))
                <p class="clubhouse-content-copy">As a PRO member, you get access to any event we host. See our upcoming events below and hopefully we see you there!</p>
            @else
                <p class="clubhouse-content-copy">We host multiple sessions per month, and unless it's a premium event, these are free to attend. Check it out and hope to see you there!</p>
            @endif
            @foreach ($new_webinars as $webinar)
                @if ($webinar->tags->contains('tag_name', '#SameHere'))
                    <div style="text-align: right;">
                        <strong style="margin:10px 0px;font-size:.9em">#SameHere</strong>
                    </div>
                @endif
                <a href="{{ $webinar->getURL(false, 'webinars') }}" class="no-underline">
                    @if ($webinar->primaryImage())
                        <img src={{ $webinar->primaryImage()->getURL('medium') }} width="500"/>
                    @else
                        <h2>{{ $webinar->name }}</h2>
                    @endif
                </a>
                <br><br>
            @endforeach
        @endif
        @if ($user->profile->email_preference_new_content_blogs && $new_blog_posts->isNotEmpty())
            <h1 class="section-title">New Blogs</h1>
            <p class="clubhouse-content-copy">We're like the Players' Tribune for the sports business. Current industry professionals share their insights and experiences in an effort to help you succeed. Grab your coffee, find an article and enjoy.</p>
            <table>
                @foreach ($new_blog_posts as $post)
                    <tr>
                        <td valign="top" style="padding-right:20px;padding-bottom:35px;width:50%;">
                            @if (!is_null($post->images))
                                <a href="/post/{{ $post->title_url}}" class="no-underline">
                                    <img src={{ $post->images->first()->getUrl('share') }} class="no-border" width="220">
                                </a>
                            @endif
                        </td>
                        <td style="padding-bottom:35px;min-width: 50%;">
                            @if ($post->tags->contains('tag_name', '#SameHere'))
                                <strong style="margin:10px 0px;font-size:.9em">#SameHere</strong>
                            @endif
                            <a href="/post/{{ $post->title_url}}" class="no-underline">
                                <h1 style="margin-bottom:0px;">{{$post->title}}</h1>
                            </a>
                            <i style="font-size: .9em;text-transform: uppercase;">By {{ $post->authored_by ?: $post->user->first_name.' '.$post->user->last_name }}</i>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
        @if ($user->profile->email_preference_new_content_webinars && $new_webinar_recordings->isNotEmpty())
            <h1 class="section-title">New Webinar Recordings</h1>
            <p class="clubhouse-content-copy">
                @if ($user->can('view-clubhouse'))
                    As a Clubhouse PRO member, one of your biggest benefits is access to more than 90 hours of webinar content in our library, on demand.
                @else
                    Become a <a href="/pro-membership">CLUBHOUSE PRO</a> and access more than 90 hours of content available on demand in our webinar library.
                @endif
                Watch and listen as experts from the 49ers, the Athletic, the 76ers, NBA2K and others talk about best practices and keys to success in sports.
            </p>
            <table cellpadding="20" cellspacing="20" align="center">
                @foreach ($new_webinar_recordings as $webinar)
                    <tr>
                        <td style="background-color: #F4F4F4;box-shadow: 0 2px 2px 0 #AAA;">
                            <a href="{{ $webinar->getURL(false, 'webinars') }}" class="no-underline">
                                <div>
                                    @if ($webinar->tags->contains('tag_name', '#SameHere'))
                                        <strong style="color:#888;margin:10px 0px;font-size:.9em">#SameHere</strong>
                                    @endif
                                    <h2>{{ $webinar->name }}</h2>
                                    <i style="color:#707070;font-size:.9em">Recorded on {{$webinar->options->first()->name}}</i>
                                </div>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
        @if ($user->cannot('view-clubhouse'))
            <h1 class="section-title"><img src="{{ asset('images/content-email-PRO-cta.png') }}" width="500"/></h1>
        @endif
        @if ($user->profile->email_preference_new_content_mentors && $new_mentors->isNotEmpty())
            <h1 class="section-title">New Mentors</h1>
            @if ($user->can('view-clubhouse'))
                <p class="clubhouse-content-copy">YOU are a PRO member, which means you get access to networking calls with more than 200 sports industry professionals. See our new mentors below, or just go to the site, search for your mentor, and set up a call. It's that easy!</p>
            @else
                <p class="clubhouse-content-copy">We have more than 200 sports industry professionals who have made themselves available for 30 minute phone conversations with our <a href="/pro-membership">CLUBHOUSE PRO</a> members. Sign up today, and start networking. They're eager to talk with you!</p>
            @endif
            <table>
                @foreach ($new_mentors as $mentor)
                    <tr>
                        <td style="padding-right:20px;padding-top:15px;padding-bottom:15px;max-width:140px;min-width:100px;">
                            @if ($mentor->contact->headshotImage || ($mentor->contact->user && $mentor->contact->user->profile->headshotImage))
                                <a href="{{ $mentor->getUrL() }}" class="no-underline">
                                    @if ($mentor->contact->headshotImage)
                                        <img src={{ $mentor->contact->headshotImage->getURL('medium') }} style="border-radius:50%" width="100">
                                    @elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
                                        <img src={{ $mentor->contact->user->profile->headshotImage->getURL('medium') }} style="border-radius:50%" width="100">
                                    @endif
                                </a>
                            @endif
                        </td>
                        <td style="padding-top:15px;padding-bottom:15px;">
                            <a href="{{ $mentor->getUrL() }}" class="no-underline">
                                <h1 style="margin-bottom:0px;">{{ $mentor->contact->getName() }}</h1>
                            </a>
                            <strong>{{ $mentor->contact->getTitle() }}</strong>
                        </td>
                        <td valign="middle" style="padding-top:15px;padding-bottom:15px;width:50px;">
                            @if ($mentor->contact->organizations()->first() && !is_null($mentor->contact->organizations()->first()->image))
                                <img src="{{ $mentor->contact->organizations()->first()->image->getURL('small') }}" width="50"/>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
        @include('emails.footer-manage-preferences', ['user' => $user])
    @endslot
@endcomponent
