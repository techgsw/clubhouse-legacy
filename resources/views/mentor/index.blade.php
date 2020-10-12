<!-- /resources/views/mentor/index.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Mentors')
@section('hero')
    <div class="row hero bg-image mentorship">
        <div class="col s12">
            <img class="responsive-img" src="/images/clubhouse/mentorship-white.png" />
            <h4 class="header">Sports Industry Mentors</h4>
            <p>Become a <a href="{{Auth::user() ? '/pro-membership' : '#register-modal'}}">Clubhouse PRO member</a> and schedule your Mentorship call now.</p>
        </div>
    </div>
@endsection
@section('scripts')
    @if(!$is_blocked)
        @include('mentor.components.scripts')
    @endif
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 center-align">
            <h4>Find your mentor below and begin a conversation today!</h4>
            <p class="sbs-red-text">Note: Clubhouse Pro members can book up to two mentorship calls per week.</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @include('mentor.forms.search', ['options' => $tags])
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card-flex-container">
                @foreach ($mentors as $mentor)
                    @include('mentor.components.list-item', ['mentor' => $mentor, 'is_blocked' => $is_blocked])
                @endforeach
                <div class="card-placeholder"></div>
                <div class="card-placeholder"></div>
                <div class="card-placeholder"></div>
            </div>
        </div>
    </div>
    @if ($mentors->count() > 0)
        <div class="row">
            <div class="col s12 center-align">
                {{ $mentors->appends(request()->all())->links('components.pagination') }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col s12 center-align">
                <p><i>No results</i></p>
            </div>
        </div>
    @endif
    @include('mentor.components.request-modal', ['is_blocked' => $is_blocked])
</div>
@endsection
