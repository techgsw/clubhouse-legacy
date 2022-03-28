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
                    <p>Thank you for getting back to us regarding the conversation with <strong>{{ $contact_job->job->organization->name }}</strong>. This career call is purely exploratory at this point, and as mentioned, they'd simply like to get to know you better.</p>
                    <br />
                    <p>Someone from the team will be in touch with you soon to coordinate the call.</p>
                    <br />
                    <p>If needed, you can complete your career profile in <a href="/"><span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup></a>. There you can update your resume and your career preferences so we can keep you in mind for other opportunities in the future.</p>
                    <br />
                    <p>If you have any questions about <span style="color: #EB2935;">the</span>Clubhouse<sup>&#174;</sup>, or the status of this conversation you can always email us at <a href="mailto:theclubhouse@generalsports.com">theclubhouse@generalsports.com</a></p>
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
