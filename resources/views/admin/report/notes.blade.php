@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<form>
    <div class="row">
        <div class="col s12 m4">
            <div class="form-group">
                <input class="drp center-align" type="text" name="date_range" id="date-range" />
                <input class="hidden" type="text" name="date_range_start" id="date-range-start" value="{{ $start_date->format('Y-m-d') }}"/>
                <input class="hidden" type="text" name="date_range_end" id="date-range-end" value="{{ $end_date->format('Y-m-d') }}"/>
            </div>
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
