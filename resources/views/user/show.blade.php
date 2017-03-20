<!-- /resources/views/user/show.blade.php -->
@extends('layouts.default')
@section('title', 'User Profile')
@section('content')
<h4 class="header">{{ $user->getName() }}</h4>
<p>Joined {{ $user->created_at->format('F j, Y g:ia') }}</p>
<p>Email: {{ $user->email }}</p>
@if ($user->title)
    <p>Title: {{ $user->title }}</p>
@endif
@if ($user->organization)
    <p>Organization: {{ $user->organization }}</p>
@endif
<p>
  <input type="checkbox" id="receives-newsletter" disabled="disabled" {{ $user->receives_newsletter ? "checked" : "" }} />
  <label for="receives-newsletter">Receives newsletter</label>
</p>
<p>
  <input type="checkbox" id="is-sales-professional" disabled="disabled" {{ $user->is_sales_professional ? "checked" : "" }} />
  <label for="is-sales-professional">Sports Sales Professional</label>
</p>
<p>
  <input type="checkbox" id="is-interested-in-jobs" disabled="disabled" {{ $user->is_interested_in_jobs ? "checked" : "" }} />
  <label for="is-interested-in-jobs">Interested in Jobs</label>
</p>
<div class="row">
    <div class="input-field col s12">
        <a href="/user/{{ $user->id }}/edit" class="btn sbs-red">Edit profile</a>
    </div>
</div>

@endsection
