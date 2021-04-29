@extends('layouts.clubhouse')
@section('title', 'Success in Sports')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card ">
                <div class="card-content">
                    <p>{{ $contact_job->contact->first_name }},</p>
                    <br />
                    <p>Thank you for getting back to us regarding the <strong>{{ $contact_job->job->title }}</strong> position with the <strong>{{ $contact_job->job->organization->name }}</strong>.</p>
                    <br />
                    <p>We’re glad to hear you’re interested in learning more about this position! Someone will be in touch with you soon to discuss next steps.</p>
                    <br />
                    <p>If you haven’t done so already (and if you’d like to), you can create a free career profile in <a href="/"><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup></a> where you can upload your latest resume and update your career preferences so we can keep you in mind for other opportunities in the future.</p>
                    <br />
                    <p>If you have any questions about SBS Consulting, <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup>, or the status of this job you can always email us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a></p>
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
