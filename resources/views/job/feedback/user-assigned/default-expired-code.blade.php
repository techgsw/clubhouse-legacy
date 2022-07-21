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
                    <p>It looks like you've already indicated that you are <strong>{{ $response[$contact_job->job_interest_response_code] }}</strong> in taking a potential career call with <strong>{{ $contact_job->job->organization->name }}</strong>.</p>
                    <br />
                    <p>If you are not interested, that's ok! Please let us know why so we can pass it along. Why aren’t you interested in taking a career call with them?</p>
                    <br />
                    @include('job.forms.negative-feedback')
                    <p>If you are interested, and want to change your status to YES, just <a href="/user-assigned/feedback/{{ $contact_job->id }}?interest=interested&token={{ $contact_job->job_interest_token }}&override=true">click here</a> and someone from their team will be in touch with you soon.</p>
                    <br />
                    <p>If you have any questions about <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup>, or the status of this conversation you can always email us at <a href="mailto:{{ __('email.info_address') }}">{{ __('email.info_address') }}</a></p>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
