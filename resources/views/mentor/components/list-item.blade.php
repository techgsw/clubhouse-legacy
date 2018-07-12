<div class="card">
    <div class="card-content text-center">
        <div>
            <a href="/mentor/{{$mentor->id}}" class="no-underline">
                <div class="center-align">
                    @if ($mentor->contact->headshotImage)
                        <img src={{ $mentor->contact->headshotImage->getURL('medium') }} style="width: 80%; max-width: 100px; border-radius: 50%; margin-top: 16px; border: 3px solid #FFF; box-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);" />
                    @else
                        <i class="fa fa-user fa-2x"></i>
                    @endif
                </div>
            </a>
        </div>
        <div>
            <h4 style="text-align: center;"><a class="no-underline" href="/mentor/{{$mentor->id}}">{{ $mentor->contact->getName() }}</a></h4>
            <p style="text-align: center;">{{ $mentor->description }}</p>
            <div class="small" style="margin-top: 12px; text-align: center;">
                <div style="margin-top: 4px">
                    @can ('view-mentor')
                        <a href="/mentor/{{ $mentor->id }}" style="margin: 0 2px;" class="small flat-button black"><i class="fa fa-calendar"></i> Contact</a>
                    @endcan
                    @can ('edit-mentor')
                        <a href="/contact/{{ $mentor->contact->id }}/mentor" style="margin: 0 2px;" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
