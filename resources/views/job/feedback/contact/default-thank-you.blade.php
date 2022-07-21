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
                    <p>Thank you for you feedback regarding the conversation with <strong>{{ $contact_job->job->organization->name }}</strong>.</p>
                    <br />
                    <p>If you have changed your mind, you have any questions about <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup>, or if you'd like to know the status of this conversation you can always email us at <a href="mailto:{{ __('email.info_address') }}">{{ __('email.info_address') }}</a></p>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
