<!-- /resources/views/admin/contact.blade.php -->
@extends('layouts.admin')
@section('title', 'Users')
@section('content')
@include('forms.admin-contact-search')
<div class="row">
    <div class="col s12" style="display: flex; flex-flow: row;">
        <button class="btn sbs-red">New</button>
        <span style="text-transform: uppercase; flex: 1 0 auto; text-align: center; vertical-align: bottom; display: inline-block; height: 36px; border-radius: 2px; background: #EFEFEF; line-height: 36px; padding: 0 2rem; margin-top: 10px;"><b>{{ $count }}</b> contacts</span>
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
                    {{ $contacts->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>
</div>
@component('components.pdf-view-modal')@endcomponent
@endsection
