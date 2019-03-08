<!-- /resources/views/admin/pipeline.blade.php -->
@extends('layouts.admin')
@section('title', 'Pipelines')
@section('content')
<div class="card-flex-container">
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/admin/pipeline/job" class="no-underline">Job Pipeline</a></span>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $total_contact_count = 5 }}</span> Contacts
            </p>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $total_inquiry_count = 5 }}</span> Inquiries
            </p>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $total_contact_count + $total_inquiry_count }}</span> In the pipeline
            </p>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/admin/pipeline/job"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> Edit Pipeline</span></a>
        </div>
    </div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
</div>
@endsection
