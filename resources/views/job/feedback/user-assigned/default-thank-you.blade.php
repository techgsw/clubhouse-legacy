@extends('layouts.clubhouse')
@section('title', 'Success in Sports')
@section('content')
@php $response = array('interested' => 'interested', 'not-interested' => 'not interested', 'do-not-contact' => 'not interested'); @endphp
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card ">
                <div class="card-content">
                    <p>{{ $contact_job->contact->first_name }},</p>
                    <br />
                    <p>Thank you for your feedback regarding the conversation with the <strong>{{ $contact_job->job->organization->name }}</strong>.</p>
                    <br />
                    <p>If you have changed your mind, have any questions about SBS Consulting, <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup>, or the status of this job you can always email us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a></p>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
