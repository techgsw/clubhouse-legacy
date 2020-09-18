<!-- /resources/views/admin/report.blade.php -->
@extends('layouts.admin')
@section('title', 'Reports')
@section('content')
<div class="card-flex-container">
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/admin/report/transactions" class="no-underline">Transactions</a></span>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $total_transactions }}</span> transactions
            </p>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $month_transaction_count }}</span> last 30 days
            </p>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $sixty_day_transaction_count }}</span> last 60 days
            </p>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/admin/report/transactions"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> View Report</span></a>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/admin/report/notes" class="no-underline">Notes</a></span>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $total_note_count }}</span> notes
            </p>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $month_note_count }}</span> last 30 days
            </p>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $sixty_day_note_count }}</span> last 60 days
            </p>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/admin/report/notes"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> View Report</span></a>
        </div>
    </div>
    <div class="card">
        <div class="card-content">
            <span class="card-title"><a href="/admin/report/clubhouse" class="no-underline">Clubhouse Users</a></span>
            <p style="text-transform: uppercase;">
                <span class="sbs-red-text">{{ $clubhouse_users_count }}</span> users
            </p>
        </div>
        <div class="card-action">
            <a class="no-underline" href="/admin/report/clubhouse"><span class="sbs-red-text"><i class="icon-left fa fa-search" aria-hidden="true"></i></span><span style="color: #000"> View Report</span></a>
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
