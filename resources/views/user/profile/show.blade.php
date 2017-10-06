<!-- /resources/views/user/profile/show.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m3 l2">
            <div class="hide-on-small-only" style="margin-top: 20px;"></div>
            @if ($profile->headshot_url)
                <img src={{ Storage::disk('local')->url($profile->headshot_url) }} style="width: 80%; max-width: 100px; border-radius: 50%;" />
            @else
                <i class="material-icons large">person</i>
            @endif
        </div>
        <div class="col s12 m9 l10">
            @can ('edit-profile', $user)
                <div class="input-field right">
                    <a href="/user/{{ $user->id }}/edit-profile" class="btn sbs-red">Edit</a>
                </div>
            @endcan
            <h3 class="header" style="display: inline-block; margin-bottom: 10px;">{{ $user->getName() }}</h3>
            <p class="small" style="margin: 4px 0;">Joined {{ $user->created_at->format('F j, Y') }}</p>
            <p class="small" style="margin: 4px 0;">Last updated {{ $user->updated_at->format('F j, Y') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @if ($user->address && ($user->address->city || $user->address->state))
                <p>Lives in <b>{{ $user->address->city}}, {{$user->address->state}}</b>.</p>
            @endif
            @if ($user->profile->job_seeking_status)
                @if ($user->profile->job_seeking_status == 'unemployed')
                    <p>Is currently <b>unemployed, actively seeking a new job</b>.</p>
                @endif
                @if ($user->profile->job_seeking_status == 'employed_active')
                    <p>Is currently <b>employed, actively seeking a new job</b>.</p>
                @endif
                @if ($user->profile->job_seeking_status == 'employed_passive')
                    <p>Is currently <b>employed, passively exploring new opportunities</b>.</p>
                @endif
                @if ($user->profile->job_seeking_status == 'employed_future')
                    <p>Is currently <b>employed, only open to future opportunities</b>.</p>
                @endif
                @if ($user->profile->job_seeking_status == 'employed_not')
                    <p>Is currently <b>employed, currently have my dream job</b>.</p>
                @endif
            @endif
            @if ($user->profile->job_seeking_region)
                @if ($user->profile->job_seeking_region == 'mw')
                    <p>Wants to work in the <b>Midwest</b>.</p>
                @endif
                @if ($user->profile->job_seeking_region == 'ne')
                    <p>Wants to work in the <b>Northeast</b>.</p>
                @endif
                @if ($user->profile->job_seeking_region == 'nw')
                    <p>Wants to work in the <b>Northwest</b>.</p>
                @endif
                @if ($user->profile->job_seeking_region == 'se')
                    <p>Wants to work in the <b>Southeast</b>.</p>
                @endif
                @if ($user->profile->job_seeking_region == 'sw')
                    <p>Wants to work in the <b>Southwest</b>.</p>
                @endif
            @endif
            @if ($user->profile->job_seeking_type)
                @if ($user->profile->job_seeking_type == 'internship')
                    <p>Next career step is <b>an internship</b>.</p>
                @endif
                @if ($user->profile->job_seeking_type == 'entry_level')
                    <p>Next career step is <b>an entry-level position</b>.</p>
                @endif
                @if ($user->profile->job_seeking_type == 'mid_level')
                    <p>Next career step is <b>a mid-level position</b>.</p>
                @endif
                @if ($user->profile->job_seeking_type == 'entry_level_management')
                    <p>Next career step is <b>an entry-level management position</b>.</p>
                @endif
                @if ($user->profile->job_seeking_type == 'mid_level_management')
                    <p>Next career step is <b>a mid-level management position</b>.</p>
                @endif
                @if ($user->profile->job_seeking_type == 'executive')
                    <p>Next career step is <b>an executive position</b>.</p>
                @endif
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Employment History</h4>
            <p></p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <h4>Educational History</h4>
            <p></p>
        </div>
    </div>
</div>
@endsection
