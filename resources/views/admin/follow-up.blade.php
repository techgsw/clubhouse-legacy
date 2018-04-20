<!-- /resources/views/admin/resources/follow-up.blade.php -->
@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<div class="row">
    <div class="col s12" style="display: flex; flex-flow: row; margin-top: 10px;">
        <span style="text-transform: uppercase; flex: 1 0 auto; text-align: center; vertical-align: bottom; display: inline-block; height: 36px; border-radius: 2px; background: #EFEFEF; line-height: 36px; padding: 0 2rem;"><b>{{ $count }}</b> follow ups</span>
    </div>
</div>
<div class="row">
    <div class="col s12">
        @if (count($contacts) > 0)
            @foreach ($contacts as $contact)
                @include('components.admin-contact-list-item', ['contact' => $contact])
            @endforeach
            @include('components.contact-notes-modal')
            <div class="row">
                <div class="col s12 center-align">
                    {{ $contacts->appends(request()->all())->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>
</div>
@component('components.pdf-view-modal')@endcomponent
@endsection
