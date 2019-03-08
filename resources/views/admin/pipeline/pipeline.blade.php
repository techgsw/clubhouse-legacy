@extends('layouts.admin')
@section('title', 'Pipeline')
@section('content')
<form action="">
    <div class="row">
        <div class="col s12 m4">
            <div class="form-group">
                <input class="drp center-align" type="text" name="date_range" id="date-range" />
                <input class="hidden" type="text" name="date_range_start" id="date-range-start" value="5"/>
                <input class="hidden" type="text" name="date_range_end" id="date-range-end" value="5"/>
            </div>
        </div>
        <div class="col s12 m8">
            <h4><span class="sbs-red-text">{{ count($clubhouse_users = 5) }}</span> Active Clubhouse Members</h4>
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
                @php
                    //dd($job_pipeline_steps);
                @endphp
                @for ($i = 0; $i < count($job_pipeline_steps); $i++)
                    The current value is {{ $steps[$i]->name . ": " . $job_pipeline_steps[$i]->name }} <br/>
                @endfor
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>
</div>
@endsection
