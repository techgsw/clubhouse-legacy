@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<div class="row center-align">
    <div class="col s6 m4 l3">
        <a class="hover-outline" href="/blog">
            <h2 class="sbs-red-text">{{ $post_count }}</h2>
            <h5 style="margin-bottom: 20px;">Blog posts</h5>
        </a>
    </div>
    @can ('create-post')
        <div class="col s6 m4 l3">
            <a class="hover-outline" href="/post/create">
                <h2 class="sbs-red-text"><i class="fa fa-plus" aria-hidden="true"></i></h2>
                <h5 style="margin-bottom: 20px;">New Post</h5>
            </a>
        </div>
    @endcan
    <div class="col s6 m4 l3">
        <a class="hover-outline" href="/admin/job">
            <h2 class="sbs-red-text">{{ $job_count }}</h2>
            <h5 style="margin-bottom: 20px;">Jobs</h5>
        </a>
    </div>
    <div class="col s6 m4 l3">
        <a class="hover-outline" href="/admin/question">
            <h2 class="sbs-red-text">{{ $question_count }}</h2>
            <h5 style="margin-bottom: 20px;">Questions</h5>
        </a>
    </div>
    <div class="col s6 m4 l3">
        <a class="hover-outline" href="/admin/user">
            <h2 class="sbs-red-text">{{ $user_count }}</h2>
            <h5 style="margin-bottom: 20px;">Users</h5>
        </a>
    </div>
</div>
<style type="text/css" media="screen">
    a.hover-outline {
        transition: all 100ms ease-in-out;
        border: 2px solid transparent;
        border-radius: 8px;
        display: block;
        margin: 8px 12px;
    }
    a.hover-outline:hover {
        border: 2px solid #F2F2F2;
    }
</style>
@endsection
