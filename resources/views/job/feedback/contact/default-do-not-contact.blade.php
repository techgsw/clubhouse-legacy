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
                    <p>We’re sorry to hear that you aren’t interested in this position. You won’t be contacted regarding <strong>any</strong> other opportunities.</p>
                    <br />
                    <p>If you change your mind, have any questions about Sports Business Solutions, <span style="color: #EB2935;">the</span>Clubhouse, or the status of this job you can always email us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a></p>
                    <br />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
