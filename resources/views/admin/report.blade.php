<!-- /resources/views/admin/report.blade.php -->
@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<form action="report">
    <div class="row">
        <div class="col s12 m4">
            <div class="form-group">
                <label for="date-range">Date range</label>
                <input class="drp" type="text" name="date_range" id="date-range" />
                <input class="hidden" type="text" name="date_range_start" id="date-range-start" value="{{ $start_date->format('j F, Y') }}"/>
                <input class="hidden" type="text" name="date_range_end" id="date-range-end" value="{{ $end_date->format('j F, Y') }}"/>
            </div>
        </div>
        <div class="col s12 m4">
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
                    <td>{{ $user->getName() }}</td>
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
