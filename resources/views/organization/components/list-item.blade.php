<div class="card large">
    <div class="card-content">
        <div style="display: flex; flex-flow: row; max-width: 100%;">
            <div style="flex: 0 0 auto; width: 100px; padding: 4px 20px 4px 0;">
                <a href="/organization/{{$organization->id}}" class="no-underline">
                    @if (!empty($organization->image))
                        <img src={{ $organization->image->getURL('medium') }} class="no-border">
                    @else
                        <div class="center-align"><i class="fa fa-building fa-2x"></i></div>
                    @endif
                </a>
            </div>
            <div style="flex: 1 1 auto;">
                <p style="font-size: 22px; line-height: 1.1;"><a class="no-underline" href="/organization/{{$organization->id}}">{{ $organization->name }}</a></p>
                @if ($organization->addresses->count() > 0)
                    <p style="margin: 8px 0;">{{ $organization->addresses->first()->city }}, {{ $organization->addresses->first()->state }}, {{ $organization->addresses->first()->country }}</p>
                @endif
                <div class="small" style="margin-top: 12px;">
                    <a href="/admin/job?organization={{urlencode($organization->name)}}" style="margin-left: 2px;" class="small flat-button black"><i class="fa fa-briefcase"></i> {{ $organization->jobs()->count() }} jobs</a>
                    <a href="/admin/contact?organization_name={{urlencode($organization->name)}}" style="margin-left: 2px;" class="small flat-button black"><i class="fa fa-user"></i> {{ $organization->contacts()->count() }} contacts</a>
                    <div style="margin-top: 4px">
                        @can ('create-job')
                            <a href="/job/create?organization={{ $organization->id }}" style="margin-left: 2px;" class="small flat-button blue"><i class="fa fa-plus"></i> New Job</a>
                        @endcan
                        @can ('edit-organization', $organization)
                            <a href="/organization/{{ $organization->id }}/edit" style="margin-left: 2px;" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
