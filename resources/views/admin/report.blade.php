<!-- /resources/views/admin/report.blade.php -->
@extends('layouts.admin')
@section('title', 'Reports')
@section('content')
<div class="card-flex-container">
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/admin/report/notes" class="no-underline">Sales</a></span>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $total_note_count }}</span> total sales 
            </p>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $month_note_count }}</span> last 30 days
            </p>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/admin/report"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> View Report</span></a>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/admin/report/notes" class="no-underline">Notes</a></span>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $total_note_count }}</span> total notes
            </p>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $month_note_count }}</span> last 30 days
            </p>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/admin/report/notes"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> View Report</span></a>
        </div>
    </div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
    <div class="card-placeholder"></div>
</div>
@endsection
