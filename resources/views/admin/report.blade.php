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
@if (count($users) > 0)
    <table class="striped">
        <thead>
            <th>Name</th>
            <th>Notes</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <th>{{ $user->getName() }}</th>
                    <td>{{ $user->authoredNoteCount($start_date, $end_date) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@include('layouts.components.messages')
<div class="row">
    <div class="col s12">
    </div>
</div>
@endsection
