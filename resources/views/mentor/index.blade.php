<!-- /resources/views/mentor/index.blade.php -->
@extends('layouts.default')
@section('title', 'Mentors')
@section('scripts')
    @include('mentor.components.scripts')
@endsection
@section('content')
<div class="container">
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
                    @include('mentor.components.list-item', ['mentor' => $mentor])
                @endforeach
                <div class="card-placeholder large"></div>
                <div class="card-placeholder large"></div>
                <div class="card-placeholder large"></div>
                <div class="card-placeholder large"></div>
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
    @include('mentor.components.request-modal')
</div>
@endsection
