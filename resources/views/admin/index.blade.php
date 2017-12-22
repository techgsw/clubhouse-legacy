@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<div class="row">
    <div class="col s6 m4 l3">
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/blog" class="no-underline">Blog</a></span>
                <a href="/blog" class="no-underline"><h5 class="sbs-red-text">{{ $post_count }} <span style="color: #000">Posts</span></h5></a>
            </div>
            @can ('create-post')
                <div class="card-action">
                    <a class="no-underline" href="/post/create"><span class="sbs-red-text"><i class="fa fa-pencil" aria-hidden="true"></i></span><span style="color: #000"> Write Post</span></a>
                </div>
            @endcan
        </div>
    </div>
    <div class="col s6 m4 l3">
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/admin/job" class="no-underline">Jobs</a></span>
                <a href="/admin/jobs" class="no-underline"><h5 class="sbs-red-text">{{ $job_count }} <span style="color: #000">Jobs</span></h5></a>
            </div>
            <div class="card-action">
                <a class="no-underline" href="/job/create"><span class="sbs-red-text"><i class="fa fa-plus" aria-hidden="true"></i></span><span style="color: #000"> List Job</span></a>
            </div>
        </div>
    </div>
    <div class="col s6 m4 l3">
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/admin/question" class="no-underline">Questions</a></span>
                <a href="/admin/question" class="no-underline"><h5 class="sbs-red-text">{{ $question_count }} <span style="color: #000">Questions</span></h5></a>
                <h5 class="sbs-red-text">{{ $answer_count }} <span style="color: #000">Answers</span></h5>
            </div>
            <div class="card-action">
                <a class="no-underline" href="/question/create"><span class="sbs-red-text"><i class="fa fa-plus" aria-hidden="true"></i></span><span style="color: #000"> Ask Question</span></a>
            </div>
        </div>
    </div>
    <div class="col s6 m4 l3">
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/admin/user" class="no-underline">Users</a></span>
                <a href="/admin/user" class="no-underline"><h5 class="sbs-red-text">{{ $user_count }} <span style="color: #000">Users</span></h5></a>
            </div>
            <div class="card-action">
                <a class="no-underline" href="/admin/user"><span class="sbs-red-text"><i class="fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> Find User</span></a>
            </div>
        </div>
    </div>
</div>
@endsection
