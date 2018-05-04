<!-- /resources/views/organization/edit.blade.php -->
@extends('layouts.default')
@section('title', 'Edit Organization')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12 m9">
            @include('organization.forms.edit')
        </div>
        <div class="col s12 m3">
            <form id="create-league" action="/league" method="post">
                {{ csrf_field() }}
                <div class="input-field">
                    <input type="text" id="league-autocomplete-input" class="league-autocomplete">
                    <label for="league-autocomplete-input">Leagues</label>
                </div>
            </form>
            <ul class="organization-leagues">
                @foreach ($organization->leagues as $league)
                    <li class="flat-button gray small tag">
                        <button type="button" name="button" class="x" tag-name="{{ $league->name }}">&times;</button>{{ $league->name }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
