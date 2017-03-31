@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<div class="row center-align">
    <a href="/admin/user">
        <div class="col s12 m4">
            <h2 class="sbs-red-text">{{ $user_count }}</h2>
            <h5>Users</h5>
        </div>
    </a>
    <a href="/admin/question">
        <div class="col s12 m4">
            <h2 class="sbs-red-text">{{ $question_count }}</h2>
            <h5>Questions</h5>
        </div>
    </a>
    <a href="/admin/job">
        <div class="col s12 m4">
            <h2 class="sbs-red-text">{{ $job_count }}</h2>
            <h5>Jobs</h5>
        </div>
    </a>
</div>
@endsection
