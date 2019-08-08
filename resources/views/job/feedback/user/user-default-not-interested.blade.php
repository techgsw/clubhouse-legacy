@extends('layouts.clubhouse')
@section('title', 'Careers in Sports')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card ">
                <div class="card-content">
                    <p>{{ $inquiry->user->first_name }},</p>
                    <br />
                    <p>Thank you for getting back to us regarding the <strong>{{ $inquiry->job->title }}</strong> position with the <strong>{{ $inquiry->job->organization->name }}</strong>.</p>
                    <br />
                    <p>We’re sorry to hear that you aren’t interested in this position. You won’t be contacted regarding this opportunity.</p>
                    <br />
                    <p>We’d love your feedback though! Why aren’t you interested in learning more about this job? <DROP DOWN> (1. I have my dream job, 2. I was just promoted, 3. I can’t leave my team/city right now, 4. I don’t like that league/team/city 5. Personal reasons, 6. Other)<p>
                    <br />
                    <p>When was the last time you updated your free career profile? Doing so will allow us to bring you more of the jobs you like in the future.</p>
                    <br />
                    <p>If you have any questions about Sports Business Solutions, <span class="sbs-red-text">the</span>Clubhouse, or the status of this job you can always email us at <a href="mailto:clubhouse@sportsbusiness.solutions">clubhouse@sportsbusiness.solutions</a></p>
                    <br />
                    <div class="center-align" style="margin-top: 20px;">
                        <a class="btn sbs-red" href="/login">Update your profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
