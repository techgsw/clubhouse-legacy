<!-- /resources/views/organization/index.blade.php -->
@extends('layouts.clubhouse')
@section('title', 'Organizations')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('organization.forms.search')
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="card-flex-container">
                @foreach ($organizations as $organization)
                    @include('organization.components.list-item', ['organization' => $organization])
                @endforeach
                <div class="card-placeholder large"></div>
                <div class="card-placeholder large"></div>
                <div class="card-placeholder large"></div>
                <div class="card-placeholder large"></div>
            </div>
        </div>
    </div>
    @if ($organizations->count() > 0)
        <div class="row">
            <div class="col s12 center-align">
                {{ $organizations->appends(request()->all())->links('components.pagination') }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col s12 center-align">
                <p><i>No results</i></p>
            </div>
        </div>
    @endif
</div>
@endsection
