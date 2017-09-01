<!-- /resources/views/user/show.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @can ('edit-user', $user)
                <div class="input-field right">
                    <a href="/user/{{ $user->id }}/edit-profile" class="btn sbs-red">Edit</a>
                </div>
            @endcan
            <h3 class="header">{{ $user->getName() }}</h3>
            <p class="small">Joined {{ $user->created_at->format('F j, Y g:ia') }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col s12 m6">
            <p>Email: {{ $user->email }}</p>
            @if ($user->title)
                <p>Title: {{ $user->title }}</p>
            @endif
            @if ($user->organization)
                <p>Organization: {{ $user->organization }}</p>
            @endif
        </div>
        <div class="col s12 m6">
            <p>
              <input type="checkbox" id="is-sales-professional" disabled="disabled" {{ $user->is_sales_professional ? "checked" : "" }} />
              <label for="is-sales-professional">Sports Sales Professional</label>
            </p>
            <p>
              <input type="checkbox" id="is-interested-in-jobs" disabled="disabled" {{ $user->is_interested_in_jobs ? "checked" : "" }} />
              <label for="is-interested-in-jobs">Interested in Jobs</label>
            </p>
        </div>
    </div>
</div>
@endsection
