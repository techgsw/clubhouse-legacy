<!-- /resources/views/admin/report.blade.php -->
@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<form action="report">
    <div class="row">
        <div class="col s4" style="display: flex; flex-flow: row; margin-top: 10px;">
            <input class="datepicker" id="start-date" type="text" name="start_date" value="{{ $start_date->format('j F, Y') }}" />
        </div>
        <div class="col s4" style="display: flex; flex-flow: row; margin-top: 10px;">
            <input class="datepicker" id="end-date" type="text" name="end_date" value="{{ $end_date->format('j F, Y') }}" />
        </div>
        <div class="col s4">
            <button class="btn sbs-red" type="submit">Submit</button>
        </div>
    </div>
</form>
<div class="row">
    @if (count($users) > 0)
        @foreach ($users as $user)
            <div class="row">
                <p>{{ $user->first_name }} : {{ $user->authoredNoteCount($start_date, $end_date) }}</p>
            </div>
        @endforeach
    @endif
</div>
@include('layouts.components.messages')
<div class="row">
    <div class="col s12">
    </div>
</div>
@endsection
