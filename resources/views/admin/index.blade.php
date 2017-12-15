@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<div class="row center-align">
    <a href="/admin/user">
        <div class="col s12 m6 l3">
            <h2 class="sbs-red-text">{{ $user_count }}</h2>
            <h5>Users</h5>
        </div>
    </a>
    <a href="/admin/question">
        <div class="col m6 l3">
            <h2 class="sbs-red-text">{{ $question_count }}</h2>
            <h5>Questions</h5>
        </div>
    </a>
    <a href="/admin/job">
        <div class="col m6 l3">
            <h2 class="sbs-red-text">{{ $job_count }}</h2>
            <h5>Jobs</h5>
        </div>
    </a>
    <a href="/post/create">
        <div class="col m6 l3">
            <h2 class="sbs-red-text">{{ $post_count }}</h2>
            <h5>Blog posts</h5>
        </div>
    </a>
</div>
@endsection
