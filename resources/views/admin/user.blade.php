<!-- /resources/views/admin/user.blade.php -->
@extends('layouts.admin')
@section('title', 'Users')
@section('content')
@include('forms.admin-user-search')
<div class="row">
    <div class="col s12" style="display: flex; flex-flow: row;">
        <span style="text-transform: uppercase; flex: 1 0 auto; text-align: center; vertical-align: bottom; display: inline-block; height: 36px; border-radius: 2px; background: #EFEFEF; line-height: 36px; padding: 0 2rem; margin-top: 10px;"><b>{{ $count }}</b> users</span>
    </div>
</div>
<div class="row">
    <div class="col s12">
        @if (count($users) > 0)
            @foreach ($users as $user)
                @include('components.admin-user-list-item', ['user' => $user])
            @endforeach
            @include('components.profile-notes-modal')
            <div class="row">
                <div class="col s12 center-align">
                    {{ $users->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>
</div>
@component('components.pdf-view-modal')@endcomponent
@endsection
