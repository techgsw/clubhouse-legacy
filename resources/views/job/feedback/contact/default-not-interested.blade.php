@extends('layouts.clubhouse')
@section('title', 'Careers in Sports')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card ">
                <div class="card-content">
                    <p>{{ $contact_job->contact->first_name }},</p>
                    <br />
                    <p>Thank you for getting back to us regarding the <strong>{{ $contact_job->job->title }}</strong> position with the <strong>{{ $contact_job->job->organization->name }}</strong>.</p>
                    <br />
                    <p>We’re sorry to hear that you aren’t interested in this position. You won’t be contacted regarding this opportunity.</p>
                    <br />
                    @if (is_null($contact_job->job_interest_negative_response))
                        @include('job.forms.negative-feedback')
                    @endif
                    <p>If you haven’t done so already (and if you’d like to), you can create a free career profile in <a href="/"><span style="color: #EB2935;">the</span>Clubhouse</a> where you can upload your latest resume and update your career preferences so we can keep you in mind for other opportunities in the future.</p>
                    <br />
                    <p>If you have any questions about Sports Business Solutions, <span style="color: #EB2935;">the</span>Clubhouse, or the status of this job you can always email us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a></p>
                    <br />
                    <div class="center-align" style="margin-top: 20px;">
                        <a class="btn sbs-red" href="/register">Create your profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
