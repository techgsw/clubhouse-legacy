@extends('layouts.clubhouse')
@section('title', 'Success in Sports')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card checkout-card">
                <div class="card-content">
                    <h5>{{ Auth::user()->first_name }},</h5>
                    <p>Thank you for extending your job posting on <strong><span class="sbs-red-text">the</span>Clubhouse<sup>&#174;</sup></strong> Job Board. A member of the SBS Consulting team will be in touch with you soon.</p>
                    <div class="center-align" style="margin-top: 20px;">
                        <a class="btn sbs-red" href="/user/{{ Auth::user()->id }}/job-postings">View my job postings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
