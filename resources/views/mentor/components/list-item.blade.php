<div class="card">
    <div class="card-content text-center">
        <div>
            <a href="/mentor/{{$mentor->id}}" class="no-underline">
                <div class="center-align"><i class="fa fa-user fa-2x"></i></div>
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
