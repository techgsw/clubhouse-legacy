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
            <p>Lives in <b>Boulder, CO</b></p>
            <p>Is <b>passively seeking job opportunities</b>.</p>
            <p>Wants to work in <b>the Northwest</b>.</p>
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
