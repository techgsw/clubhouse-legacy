<a href="{{ $mentor->getUrl() }}" class="no-underline">
<div class="card">
    <div class="card-content text-center">
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
            <h4><a class="no-underline">{{ $mentor->contact->getName() }}</a></h4>
            <p class="title"><strong>{{ $mentor->contact->getTitle() }}</strong></p>
            <br />
            <p>{{ $mentor->description }}</p>
            <div class="small" style="margin-top: 12px; text-align: center;">
                <div style="margin-top: 4px">
                    @can ('view-mentor')
                        <a class="small flat-button black mentor-request-trigger" href="#mentor-request-modal" mentor-id="{{ $mentor->id }}" mentor-name="{{ $mentor->contact->getName() }}" style="margin: 2px;"><i class="fa fa-handshake-o"></i> Schedule a meeting</a>
                    @else
                        <a class="small flat-button black" href="/"><i class="fa fa-handshake-o"></i> Schedule a meeting</a>
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
