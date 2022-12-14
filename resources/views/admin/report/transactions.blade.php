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
@include('layouts.components.messages')
<div class="row">
    <div class="col s12">
        <h5><strong>Transactions By Product Type</strong></h5>
        <canvas sbs-report="customer-purchase-count-line-graph" height="350" width="1500"></canvas>
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
                        <td><a href="/product/{{ $transaction->product_id }}">{{ $transaction->name }}</a></td>
                        <td>{{ $transaction->tag_name }}</td>
                        <td><a href="/user/{{ $transaction->user_id }}/profile">{{ $transaction->first_name }} {{ $transaction->last_name }}</a></td>
                        <td><a href="mailto: {{ $transaction->email }}">{{ $transaction->email }}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
