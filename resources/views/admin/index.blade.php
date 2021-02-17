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
            <span class="card-title"><a href="/session" class="no-underline">Archives</a></span>
            <p style="text-transform: uppercase;">
                <a href="/session" class="no-underline"><span class="sbs-red-text">{{ $session_count }}</span> sessions</a>
            </p>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/archives#sessions"><span class="sbs-red-text"><i class="icon-left fa fa-eye" aria-hidden="true"></i></span><span style="color: #000"> View archives</span></a>
        </div>
        @can ('create-post')
            <div class="card-action">
                <a class="no-underline" href="/session/create"><span class="sbs-red-text"><i class="icon-left fa fa-pencil" aria-hidden="true"></i></span><span style="color: #000"> New Session</span></a>
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
            <a class="no-underline" href="/admin/job/disciplines"><span class="sbs-red-text"><i class="icon-left fa fa-pencil" aria-hidden="true"></i></span><span style="color: #000"> Edit Disciplines</span></a>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/job/create"><span class="sbs-red-text"><i class="icon-left fa fa-plus" aria-hidden="true"></i></span><span style="color: #000"> List Job</span></a>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/admin/organization" class="no-underline">Organizations</a></span>
            <p style="text-transform: uppercase;">
                <a href="/admin/organization" class="no-underline"><span class="sbs-red-text">{{ $organization_count }}</span> organizations</a>
            </p>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/organization/create"><span class="sbs-red-text"><i class="icon-left fa fa-plus" aria-hidden="true"></i></span><span style="color: #000"> new org</span></a>
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
    @can ('follow-up')
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/admin/follow-up" class="no-underline">Follow Up</a></span>
                <p style="text-transform: uppercase;">
                    <a href="/admin/follow-up" class="no-underline"><span class="sbs-red-text">{{ $today_follow_up_count }}</span> today</a>
                </p>
                <p style="text-transform: uppercase;">
                    <a href="/admin/follow-up" class="no-underline"><span class="sbs-red-text">{{ $overdue_follow_up_count }}</span> overdue</a>
                </p>
                <p style="text-transform: uppercase;">
                    <a href="/admin/follow-up" class="no-underline"><span class="sbs-red-text">{{ $upcoming_follow_up_count }}</span> upcoming</a>
                </p>
            </div>
            <div class="card-action">
                <a class="no-underline" href="/admin/follow-up"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> View All</span></a>
            </div>
        </div>
    @endcan
    @can ('view-mentor')
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/mentor" class="no-underline">Mentors</a></span>
                <p style="text-transform: uppercase;">
                    <span class="sbs-red-text">{{ $mentor_count }}</span> active mentor{{ $mentor_count == 1 ? "" : "s" }}
                </p>
            </div>
            <div class="card-action">
                <a class="no-underline" href="/mentor"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> View Mentors</span></a>
            </div>
        </div>
    @endcan
    <!-- WE ARE NOT IN ADMIN REPORTS -->
    @can ('view-admin-pipelines')
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/admin/pipeline" class="no-underline">Pipelines</a></span>
                <p style="text-transform: uppercase;">
                    <a href="/admin/pipeline/job" class="no-underline">Job Pipeline</a>
                </p>
                <!-- <p style="text-transform: uppercase;">
                    <a href="/admin/report/notes" class="no-underline">Notes Report</a>
                </p> -->
            </div>
            <div class="card-action">
                <a class="no-underline" href="/admin/pipeline"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> View Pipelines</span></a>
            </div>
        </div>
    @endcan
    @can ('admin-product')
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/product/admin" class="no-underline">Products</a></span>
                <p style="text-transform: uppercase;">
                    <span class="sbs-red-text">{{ $product_count }}</span> product{{ $product_count == 1 ? "" : "s" }}
                </p>
            </div>
            <div class="card-action">
                <a class="no-underline" href="/product/admin"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> View Products</span></a>
            </div>
            <div class="card-action">
                <a class="no-underline" href="/product/create"><span class="sbs-red-text"><i class="icon-left fa fa-plus" aria-hidden="true"></i></span><span style="color: #000"> New Product</span></a>
            </div>
        </div>
    @endcan
    @can ('view-admin-reports')
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/admin/report" class="no-underline">Reports</a></span>
                <p style="text-transform: uppercase;">
                    <a href="/admin/report/transactions" class="no-underline">Transactions</a>
                </p>
                <p style="text-transform: uppercase;">
                    <a href="/admin/report/notes" class="no-underline">Notes</a>
                </p>
                <p style="text-transform: uppercase;">
                    <a href="/admin/report/clubhouse" class="no-underline">Clubhouse</a>
                </p>
            </div>
            <div class="card-action">
                <a class="no-underline" href="/admin/report"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> View Reports</span></a>
            </div>
        </div>
    @endcan
    @can ('admin-image')
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/admin/image" class="no-underline">Images</a></span>
                <p style="text-transform: uppercase;">
                    <a href="/admin/image" class="no-underline"><span class="sbs-red-text">{{ $image_count }}</span> images</a>
                </p>
            </div>
        </div>
    @endcan
    @can ('edit-email')
        <div class="card">
            <div class="card-content">
                <span class="card-title"><a href="/email" class="no-underline">Email</a></span>
                <p style="text-transform: uppercase;">
                    <a href="/email" class="no-underline"><span class="sbs-red-text">{{ $email_count }}</span> emails</a>
                </p>
            </div>
        </div>
    @endcan
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
</div>
@endsection
