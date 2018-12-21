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
        <div class="col s12 m8">
            <h4><span class="sbs-red-text">{{ count($clubhouse_users) }}</span> Active Clubhouse Members</h4>
        </div>
    </div>
</form>
@include('layouts.components.messages')
<div class="row">
    <div class="col s12">
        <h5><strong>Transactions By Product Type</strong></h5>
        <canvas sbs-report="customer-purchase-count-bar-graph" height="350" width="1500"></canvas>
    </div>
</div>
<div class="row">
    <div class="col s12">
        <table class="responsive-table striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Customer</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->date }}</td>
                        <td>{{ $transaction->name }}</td>
                        <td>{{ $transaction->tag_name }}</td>
                        <td>{{ $transaction->first_name }} {{ $transaction->last_name }}</td>
                        <td>{{ $transaction->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
