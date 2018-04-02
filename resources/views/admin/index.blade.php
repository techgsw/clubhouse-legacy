@extends('layouts.admin')
@section('title', 'Admin Dashboard')
@section('content')
<div class="card-flex-container">
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/admin/contact" class="no-underline">Contacts</a></span>
            <p style="text-transform: uppercase;">
                <a href="/admin/contact" class="no-underline"><span class="sbs-red-text">{{ $contact_count }}</span> contacts</a>
            </p>
            <p style="text-transform: uppercase;">
                <a href="/admin/contact" class="no-underline"><span class="sbs-red-text">{{ $user_count }}</span> users</a>
            </p>
        </div>
        @can ('view-contact')
            <div class="card-action">
                <a class="no-underline" href="/admin/contact"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> Find Contact</span></a>
            </div>
        @endcan
        @can ('edit-contact')
            <div class="card-action">
                <a class="no-underline" href="/contact/create"><span class="sbs-red-text"><i class="icon-left fa fa-plus" aria-hidden="true"></i></span><span style="color: #000"> New Contact</span></a>
            </div>
        @endcan
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/blog" class="no-underline">Blog</a></span>
            <p style="text-transform: uppercase;">
                <a href="/blog" class="no-underline"><span class="sbs-red-text">{{ $post_count }}</span> posts</a>
            </p>
        </div>
        @can ('create-post')
            <div class="card-action">
                <a class="no-underline" href="/post/create"><span class="sbs-red-text"><i class="icon-left fa fa-pencil" aria-hidden="true"></i></span><span style="color: #000"> Write Post</span></a>
            </div>
        @endcan
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/blog" class="no-underline">Archives</a></span>
            <p style="text-transform: uppercase;">
                <a href="/archives" class="no-underline"><span class="sbs-red-text">{{ $session_count }}</span> sessions</a>
            </p>
        </div>
        @can ('create-post')
            <div class="card-action">
                <a class="no-underline" href="/session/create"><span class="sbs-red-text"><i class="icon-left fa fa-pencil" aria-hidden="true"></i></span><span style="color: #000"> Create Session</span></a>
            </div>
        @endcan
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/admin/job" class="no-underline">Jobs</a></span>
            <p style="text-transform: uppercase;">
                <a href="/admin/job" class="no-underline"><span class="sbs-red-text">{{ $job_count }}</span> jobs</a>
            </p>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/job/create"><span class="sbs-red-text"><i class="icon-left fa fa-plus" aria-hidden="true"></i></span><span style="color: #000"> List Job</span></a>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/admin/question" class="no-underline">Questions</a></span>
            <p style="text-transform: uppercase;">
                <a href="/admin/question" class="no-underline"><span class="sbs-red-text">{{ $question_count }}</span> questions</a>
            </p>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $answer_count }}</span> answers
            </p>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/question/create"><span class="sbs-red-text"><i class="icon-left fa fa-plus" aria-hidden="true"></i></span><span style="color: #000"> Ask Question</span></a>
        </div>
    </div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
</div>
@endsection
