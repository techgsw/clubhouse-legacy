<div class="card">
    <div class="card-content center-align text-center" style="position: relative;">
        <div>
            <div class="center-align">
                <a href="{{ $mentor->getUrl() }}" class="no-underline">
                    @if ($mentor->contact->headshotImage)
                        <img src="{{ $mentor->contact->headshotImage->getURL('medium') }}" style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" class="headshot" />
                    @elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
                        <img src="{{ $mentor->contact->user->profile->headshotImage->getURL('medium') }}" style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" class="headshot" />
                    @else
                        <i class="fa fa-user fa-2x"></i>
                    @endif
                </a>
                @if ($mentor->getLinkedInLink())
                   <a class="no-underline" href="{{$mentor->getLinkedInLink()}}">
                       <i class="hide-on-small-and-down fa fa-linkedin-square" style="position:absolute;top:21%;font-size:1.5em;"></i>
                       <i class="hide-on-med-and-up fa fa-linkedin-square" style="position:absolute;top:21%;font-size:2.5em;"></i>
                   </a>
                @endif
            </div>
        </div>
        <div class="center-align">
            <h4 style="min-height: 60px;"><a href="{{ $mentor->getUrl() }}" class="no-underline">{{ $mentor->contact->getName() }}</a></h4>
            <a href="{{ $mentor->getUrl() }}" class="no-underline"><p style="min-height: 70px; font-size: 13px;" class="title"><strong>{{ $mentor->contact->getTitle() }}</strong></p></a>
            @if ($mentor->contact->organizations()->first())
                @if (!is_null($mentor->contact->organizations()->first()->image))
                    <div style="height: 100px;">
                        <a href="{{ $mentor->getUrl() }}" class="no-underline">
                            <img src="{{ $mentor->contact->organizations()->first()->image->getURL('small') }}" class="responsive-img" style="max-height: 100px;" />
                        </a>
                    </div>
                @endif
            @endif
            <div style="margin-top:10px">
                @foreach($mentor->tags as $tag)
                    <a href="/mentor?tag={{ $tag->name }}" class="flat-button black small" style="margin:2px;">{{ $tag->name }}</a>
                @endforeach
            </div>
            <!--<p>{{ $mentor->description }}</p>-->
        </div>
        <div style="height: 55px">
            <div class="small" style="margin-top: 12px; text-align: center; position: absolute; bottom: 20px; left: 50%; margin-left: -50%; padding: 0 10px; width: 100%;">
                <div style="margin-top: -10px">
                    @can ('view-clubhouse')
                        @if ($mentor->calendly_link)
                            <a class="small flat-button red mentor-request-trigger calendly" href="#mentor-calendly-modal" mentor-id="{{$mentor->id}}" user-name="{{Auth::user()->first_name}} {{Auth::user()->last_name}}" user-email="{{Auth::user()->email}}" calendly-link="{{$is_blocked ? '' : base64_encode($mentor->calendly_link)}}" style="margin: 2px;"><i class="fa fa-phone"></i> Schedule a call</a>
                        @else
                            @php
                                $timezones = array(
                                    'hst' => 'Hawaii (GMT-10:00)',
                                    'akdt' => 'Alaska (GMT-09:00)',
                                    'pst' => 'Pacific Time (US & Canada) (GMT-08:00)',
                                    'azt' => 'Arizona (GMT-07:00)',
                                    'mst' => 'Mountain Time (US & Canada) (GMT-07:00)',
                                    'cdt' => 'Central Time (US & Canada) (GMT-06:00)',
                                    'est' => 'Eastern Time (US & Canada) (GMT-05:00)'
                                );
                            @endphp
                            <a class="small flat-button red mentor-request-trigger" href="#mentor-request-modal" mentor-id="{{ $mentor->id }}" mentor-name="{{ $mentor->contact->getName() }}" mentor-day-preference-1="{{ ucwords($mentor->day_preference_1) }}" mentor-day-preference-2="{{ ucwords($mentor->day_preference_2) }}" mentor-day-preference-3="{{ ucwords($mentor->day_preference_3) }}" mentor-time-preference-1="{{ ucwords($mentor->time_preference_1) }}" mentor-time-preference-2="{{ ucwords($mentor->time_preference_3) }}" mentor-time-preference-3="{{ ucwords($mentor->time_preference_3) }}" mentor-timezone="{{ (($mentor->timezone) ? $timezones[$mentor->timezone] : 'Not specified') }}" style="margin: 2px;"><i class="fa fa-phone"></i> Schedule a call</a>
                        @endif
                    @else
                        <p style="font-size: 14px;">Want to schedule a call?</p>
                        @if (Auth::guest())
                            <a class="small flat-button red" href="#register-modal">Become a Clubhouse Pro</a>
                        @else
                            <a class="small flat-button red" href="/pro-membership">Become a Clubhouse Pro</a>
                        @endif
                    @endcan
                    @if (Auth::user() && (Auth::user()->can('edit-mentor') || Auth::user()->contact->id == $mentor->contact->id))
                        <a href="/contact/{{ $mentor->contact->id }}/mentor" style="margin: 2px;" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
