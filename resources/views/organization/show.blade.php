<!-- /resources/views/organization/show.blade.php -->
@extends('layouts.clubhouse')
@section('title', "$organization->name")
@section('content')
<div class="container" style="padding-bottom: 40px;">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    @include('layouts.components.messages')
    <div class="row organization-show">
        <div class="col s12">
            <div style="float: right; margin-top: 6px;">
                @can ('edit-organization', $organization)
                    <a href="/organization/{{ $organization->id }}/edit" class="flat-button blue"><i class="icon-left fa fa-pencil"></i>Edit</a>
                @endcan
                @can ('create-job')
                    <a href="/job/create?organization={{ $organization->id }}" class="flat-button blue"><i class="icon-left fa fa-briefcase"></i>List job</a>
                @endcan
            </div>
            <h3>{{ $organization->name }}</h3>
            <div style="display: flex; flex-flow: row;">
                <!-- Logo & Address -->
                <div class="card" style="flex: 1 0 auto; display: flex; flex-flow: row; padding: 10px 24px; margin: 12px; margin-left: 0;">
                    <div style="flex: 0 0 80px; text-align: center; margin: 15px 0; padding-right: 10px;">
                        @if ($organization->image)
                            <img src={{ $organization->image->getURL('medium') }} style="max-height: 80px;">
                        @else
                            <div class="center-align"><i class="fa fa-building fa-2x"></i></div>
                        @endif
                    </div>
                    <div style="flex: 0 0 auto;">
                        @if ($organization->addresses->count() > 0)
                            @include('address.components.address', ['address' => $organization->addresses->first()])
                        @else
                            <p><i>No address</i></p>
                        @endif
                    </div>
                </div>
                <!-- Stats -->
                <div class="card" style="flex: 0 0 120px; padding: 10px 24px; text-align: center; margin: 12px; text-transform: uppercase; letter-spacing: 0.6px;">
                    <a href="/admin/job?organization={{urlencode($organization->name)}}">
                        <p style="font-size: 22px; color: #EB2935; margin-bottom: 6px;">{{ $organization->jobs()->count() }}</p>
                        <p style="margin-top: 6px;">jobs</p>
                    </a>
                </div>
                <div class="card" style="flex: 0 0 120px; padding: 10px 24px; text-align: center; margin: 12px; text-transform: uppercase; letter-spacing: 0.6px;">
                    <a href="/admin/contact?search={{urlencode('organization:"'.$organization->name.'"')}}">
                        <p style="font-size: 22px; color: #EB2935; margin-bottom: 6px;">{{ $organization->contacts()->count() }}</p>
                        <p style="margin-top: 6px;">contacts</p>
                    </a>
                </div>
            </div>
            @if ($jobs->count() > 0)
                <div style="margin-top: 20px">
                    @foreach ($jobs as $job)
                        @include('job.components.list-item', ['job' => $job])
                    @endforeach
                    <div class="center-align">
                        {{ $jobs->appends(request()->all())->links('components.pagination') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
