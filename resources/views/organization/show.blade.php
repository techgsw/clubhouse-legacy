<!-- /resources/views/organization/show.blade.php -->
@extends('layouts.default')
@section('title', "$organization->name")
@section('content')
<div class="container" style="padding-bottom: 40px;">
    <div class="row organization-show">
        <div class="col s12">
            <div class="small" style="float: right; margin-top: 6px;">
                @can ('edit-organization')
                    <a href="/organization/{{ $organization->id }}/edit" class="small flat-button blue"><i class="fa fa-pencil"></i> Edit</a>
                @endcan
            </div>
            <h3>{{ $organization->name }}</h3>
            <div style="display: flex; flex-flow: row;">
                <!-- Logo & Address -->
                <div class="card" style="display: flex; flex-flow: row; padding: 10px 24px; margin: 12px; margin-left: 0;">
                    @if ($organization->image)
                        <div style="flex: 0 0 80px; text-align: center; margin: 15px 0; padding-right: 10px;">
                            <img src={{ $organization->image->getURL('medium') }} style="max-height: 80px;">
                        </div>
                    @endif
                    @if ($organization->addresses->count() > 0)
                        <div style="flex: 0 0 auto;">
                            @include('address.components.address', ['address' => $organization->addresses->first()])
                        </div>
                    @endif
                </div>
                <!-- Stats -->
                <div class="card" style="flex: 0 0 120px; padding: 10px 24px; text-align: center; margin: 12px; text-transform: uppercase; letter-spacing: 0.6px;">
                    <p style="font-size: 22px; color: #EB2935; margin-bottom: 6px;">{{ $organization->jobs()->count() }}</p>
                    <p style="margin-top: 6px;">jobs</p>
                </div>
                <div class="card" style="flex: 0 0 120px; padding: 10px 24px; text-align: center; margin: 12px; text-transform: uppercase; letter-spacing: 0.6px;">
                    <p style="font-size: 22px; color: #EB2935; margin-bottom: 6px;">{{ $organization->contacts()->count() }}</p>
                    <p style="margin-top: 6px;">contacts</p>
                </div>
            </div>
            <div style="margin-top: 20px">
                @foreach ($jobs as $job)
                    @include('job.components.list-item', ['job' => $job])
                @endforeach
                <div class="center-align">
                    {{ $jobs->appends(request()->all())->links('components.pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
