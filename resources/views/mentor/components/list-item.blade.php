<a href="{{ $mentor->getUrl() }}" class="no-underline">
    <div class="card">
        <div class="card-content center-align text-center" style="">
            <div>
                <div class="center-align">
                    @if ($mentor->contact->headshotImage)
                        <img src={{ $mentor->contact->headshotImage->getURL('medium') }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" />
                    @elseif ($mentor->contact->user && $mentor->contact->user->profile->headshotImage)
                        <img src={{ $mentor->contact->user->profile->headshotImage->getURL('medium') }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" />
                    @else
                        <i class="fa fa-user fa-2x"></i>
                    @endif
                </div>
            </div>
            <div class="center-align">
                <h4 style="min-height: 60px;"><a class="no-underline">{{ $mentor->contact->getName() }}</a></h4>
                <p style="min-height: 70px;" class="title"><strong>{{ $mentor->contact->getTitle() }}</strong></p>
                <br />
                @if ($mentor->contact->organizations()->first())
                    <img src="{{ $mentor->contact->organizations()->first()->image->getURL('medium') }}" class="responsive-img" style="margin-top: -65px; margin-left: -10px; max-width: 200px; max-height: 200px;" />
                @endif
                <!--<p>{{ $mentor->description }}</p>-->
                <div class="small" style="margin-top: 12px; text-align: center;">
                    <div style="margin-top: -40px">
                        @can ('view-clubhouse')
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
                            <a class="small flat-button black mentor-request-trigger" href="#mentor-request-modal" mentor-id="{{ $mentor->id }}" mentor-name="{{ $mentor->contact->getName() }}" mentor-day-preference-1="{{ ucwords($mentor->day_preference_1) }}" mentor-day-preference-2="{{ ucwords($mentor->day_preference_2) }}" mentor-day-preference-3="{{ ucwords($mentor->day_preference_3) }}" mentor-time-preference-1="{{ ucwords($mentor->time_preference_1) }}" mentor-time-preference-2="{{ ucwords($mentor->time_preference_3) }}" mentor-time-preference-3="{{ ucwords($mentor->time_preference_3) }}" mentor-timezone="{{ (($mentor->timezone) ? $timezones[$mentor->timezone] : 'Not specified') }}" style="margin: 2px;"><i class="fa fa-phone"></i> Schedule a meeting</a>
                        @else
                            <a class="small flat-button black" href="/"><i class="fa fa-phone"></i> Schedule a meeting</a>
                        @endcan
                        @can ('edit-mentor')
                            <a href="/contact/{{ $mentor->contact->id }}/mentor" style="margin: 2px;" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
