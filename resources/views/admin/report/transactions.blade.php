@extends('layouts.admin')
@section('title', 'Transactions')
@section('content')
<form action="">
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
<div class="row">
    <h3>{{ count($clubhouse_users) }} Active Clubhouse Members</h3>
</div>
@include('layouts.components.messages')
<div class="row">
    <div class="col s12">
        <canvas sbs-report="customer-purchase-count-bar-graph" height="350" width="1500"></canvas>
    </div>
</div>
@endsection
