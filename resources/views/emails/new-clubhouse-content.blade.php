@php $pd = new Parsedown(); @endphp
@component('emails.layout')
    @slot('body')
        <p>{{$user->first_name}},</p>
        @if ($user->can('view-clubhouse'))
            <p>Thank you for being a Clubhouse PRO member! Check out our new content and be sure to take advantage of your membership below.</p>
        @else
            <p>Thank you for being a part of theClubhouse<sup>&#174;</sup> community! There is exciting new content for you below, enjoy.</p>
        @endif
        @if ($user->profile->email_preference_new_content_webinars && $new_webinars->isNotEmpty())
            <hr>
            <h1 class="section-title">New Webinars</h1>
            @if ($user->can('view-clubhouse'))
                <p class="clubhouse-content-copy">As a PRO member, you get access to any event we host. See our upcoming events below and hopefully we see you there!</p>
            @else
                <p class="clubhouse-content-copy">We host multiple sessions per month, and unless it's a premium event, these are free to attend. Check them out and hope to see you there!</p>
            @endif
            @foreach ($new_webinars as $webinar)
                @if ($webinar->tags->contains('tag_name', '#SameHere'))
                    <div style="text-align: right;">
                        <strong style="margin:10px 0px;font-size:.9em">#SameHere</strong>
                    </div>
                @endif
                <a href="{{ env('CLUBHOUSE_URL').$webinar->getURL(false, 'webinars') }}" class="no-underline">
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
            <hr>
            <h1 class="section-title">New Blogs</h1>
            <p class="clubhouse-content-copy">Current industry professionals share their insights and experiences in an effort to help you succeed.</p>
            <table>
                @foreach ($new_blog_posts as $post)
                    <tr>
                        <td style="padding-bottom:35px;">
                            @if (!is_null($post->images))
                                <a href="{{env('CLUBHOUSE_URL').'/post/'.$post->title_url}}" class="no-underline">
                                    <img src="{{ $post->images->first()->getUrl('share') }}" class="no-border" width="500">
                                </a>
                            @endif
                            @if ($post->tags->contains('tag_name', '#SameHere'))
                                <strong style="margin:10px 0px;font-size:.9em">#SameHere</strong>
                            @endif
                            <a href="{{env('CLUBHOUSE_URL').'/post/'.$post->title_url}}" class="no-underline">
                                <h1 style="margin-top:10px;margin-bottom:0px;">{{$post->title}}</h1>
                            </a>
                            @php
                                $parsedown = new Parsedown();
                                $body = strip_tags($parsedown->text($post->body));
                                $post_length = strlen($body);
                                $index = 140;
                            @endphp
                            @if ($post_length > $index)
                                @while (!preg_match('/\s/', $body[$index]) && $post_length > $index)
                                    @php $index++; @endphp
                                @endwhile
                                <p style="font-size: .9em;margin-top:10px;">{{ substr($body, 0, $index) }}...</p>
                            @else
                                <p style="font-size: .9em;margin-top:10px;">{{ $body }}</p>
                            @endif
                            <a class="email-sbs-red-button" href="{{env('CLUBHOUSE_URL').'/post/'.$post->title_url}}" style="margin-bottom:15px;margin-top:10px;">
                                <!--[if mso]>
                                <i style="letter-spacing: 25px; mso-font-width: -100%; mso-text-raise: 30pt;">&nbsp;</i>
                                <![endif]-->
                                <strong style="mso-text-raise: 15pt;">Read more</strong>
                                <!--[if mso]>
                                <i style="letter-spacing: 25px; mso-font-width: -100%;">&nbsp;</i>
                                <![endif]-->
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
        @if ($user->profile->email_preference_new_content_webinars && $new_webinar_recordings->isNotEmpty())
            <hr>
            <h1 class="section-title">New Webinar Recordings</h1>
            <p class="clubhouse-content-copy">
                @if ($user->can('view-clubhouse'))
                    As a Clubhouse PRO member, one of your biggest benefits is access to more than 90 hours of webinar content in our library, on demand.
                @else
                    Become a <a href="{{env('CLUBHOUSE_URL')}}/pro-membership">CLUBHOUSE PRO</a> and access more than 90 hours of content available on demand in our webinar library.
                @endif
            </p>
            <table cellpadding="20" cellspacing="20" align="center">
                @foreach ($new_webinar_recordings as $webinar)
                    <tr>
                        <td style="background-color: #EAEAEA;box-shadow: 0 2px 2px 0 #AAA;">
                            <a href="{{ env('CLUBHOUSE_URL').$webinar->getURL(false, 'webinars') }}" class="no-underline">
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
        @if ($user->profile->email_preference_new_content_mentors && $new_mentors->isNotEmpty())
            <hr>
            <h1 class="section-title">New Mentors</h1>
            @if ($user->can('view-clubhouse'))
                <p class="clubhouse-content-copy">You are a PRO member, which means you get access to networking calls with more than 200 sports industry professionals. See our new mentors below, or just go to the site, search for your mentor, and set up a call. It's that easy!</p>
            @else
                <p class="clubhouse-content-copy">We have more than 200 sports industry professionals who have made themselves available for 30 minute phone conversations with our <a href="{{env('CLUBHOUSE_URL')}}/pro-membership">CLUBHOUSE PRO</a> members. Sign up today, and start networking.</p>
            @endif
            <table>
                @foreach ($new_mentors as $mentor)
                    <tr>
                        <td style="padding-right:20px;padding-top:15px;padding-bottom:15px;max-width:140px;min-width:100px;text-align:center;">
                            @if ($mentor->contact->headshotImage || ($mentor->contact->user && $mentor->contact->user->profile->headshotImage))
                                <a href="{{ env('CLUBHOUSE_URL').$mentor->getUrL() }}" class="no-underline">
                                    @if ($mentor->contact->headshotImage)
                                        <img src={{ $mentor->contact->headshotImage->getURL('medium') }} style="border-radius:50%" width="110">
                                    @elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
                                        <img src={{ $mentor->contact->user->profile->headshotImage->getURL('medium') }} style="border-radius:50%" width="110">
                                    @endif
                                </a>
                            @endif
                            @if ($mentor->contact->organizations()->first() && !is_null($mentor->contact->organizations()->first()->image))
                                <img src="{{ $mentor->contact->organizations()->first()->image->getURL('small') }}" width="80"/>
                            @endif
                        </td>
                        <td style="padding-top:15px;padding-bottom:15px;">
                            <a href="{{ env('CLUBHOUSE_URL').$mentor->getUrL() }}" class="no-underline">
                                <h1 style="margin-bottom:0px;">{{ $mentor->contact->getName() }}</h1>
                            </a>
                            <strong>{{ $mentor->contact->getTitle() }}</strong>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
        @if ($user->profile->email_preference_new_content_training_videos && $new_training_videos->isNotEmpty())
            <hr>
            <h1 class="section-title">New Sales Vault Videos</h1>
            <table cellpadding="20" cellspacing="20" align="center">
                @foreach ($new_training_videos as $video)
                    <tr>
                        <td style="background-color: #EAEAEA;box-shadow: 0 2px 2px 0 #AAA;">
                            <a href="{{ env('CLUBHOUSE_URL').$video->getURL(false, 'training/training-videos') }}" class="no-underline">
                                <div>
                                    <h2>{{ $video->name }}</h2>
                                    <p style="color:#707070;font-size:.9em">{!! $pd->text($video->getCleanDescription()) !!}</p>
                                </div>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
        @if ($user->cannot('view-clubhouse'))
            <hr>
            <h1 class="section-title"><a href="{{env('CLUBHOUSE_URL').'/pro-membership'}}"><img src="{{ asset('images/content-email-PRO-cta.png') }}" width="500"/></a></h1>
        @endif
        <tr>
            <td align="center" style="padding-bottom:20px;">
                <p style="font-size:.9em;text-align:center;">Please contact <a href="mailto:{{ __('email.info_address') }}">{{ __('email.info_address') }}</a> for any questions or issues
                    <br>
                    <a href="{{env('CLUBHOUSE_URL')}}/user/self/edit-profile">Change which content you'd like to hear about</a>
                </p>
            </td>
        </tr>
        @include('emails.footer-manage-preferences', ['user' => $user])
    @endslot
@endcomponent
