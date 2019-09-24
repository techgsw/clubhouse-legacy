@extends('layouts.clubhouse')
@section('title', 'Careers in Sports')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card checkout-card">
                <div class="card-content">
                    <h5>{{ Auth::user()->first_name }},</h5>
                    <p>Thank you for extending your job posting on <strong><span class="sbs-red-text">the</span>Clubhouse</strong> Job Board. A receipt has been emailed to you with all your purchase details.</p>
                    <div class="center-align" style="margin-top: 20px;">
                        <a class="btn sbs-red" href="/user/{{ Auth::user()->id }}/job-postings">View my job postings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
