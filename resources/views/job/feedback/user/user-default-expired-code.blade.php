@extends('layouts.clubhouse')
@section('title', 'Careers in Sports')
@section('content')
@php $response = array('interested' => 'interested', 'not_interested' => 'not interested', 'dnc' => 'not interested'); @endphp
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card ">
                <div class="card-content">
                    <p>{{ $inquiry->user->first_name }},</p>
                    <br />
                    <p>It looks like you already indicated that you are <strong>{{ $response[$inquiry->job_interest_response_code] }}</strong> in the <strong>{{ $inquiry->job->title }}</strong> position with the <strong>{{ $inquiry->job->organization->name }}</strong>.</p>
                    <br />
                    <p>If you have changed your mind, have any questions about Sports Business Solutions, <span class="sbs-red-text">the</span>Clubhouse, or the status of this job you can always email us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a></p>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
