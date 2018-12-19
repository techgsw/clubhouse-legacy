@extends('layouts.admin')
@section('title', 'Sales')
@section('content')
<form action="report">
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
<div>
    <h3>{{ count($clubhouse_users) }} Clubhouse Members</h3>
</div>
@include('layouts.components.messages')
<div class="row">
    <div class="col s12">
    </div>
</div>
@endsection
