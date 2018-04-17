<!-- /resources/views/admin/contact.blade.php -->
@extends('layouts.admin')
@section('title', 'Users')
@section('content')
@include('forms.admin-contact-search')
<div class="row">
    <div class="col s12" style="display: flex; flex-flow: row; margin-top: 10px;">
        <a href="/contact/create" class="btn sbs-red" style="margin-right: 10px;"><i class="fa fa-plus icon-left"></i>New</a>
        @can ('view-contact')
            <button class="btn sbs-red" id="download-search-contacts" style="margin-right: 10px;"><i class="fa fa-download icon-left"></i>Download</button>
        @endcan
        <span style="text-transform: uppercase; flex: 1 0 auto; text-align: center; vertical-align: bottom; display: inline-block; height: 36px; border-radius: 2px; background: #EFEFEF; line-height: 36px; padding: 0 2rem;"><b>{{ $count }}</b> contacts</span>
    </div>
</div>
@include('layouts.components.messages')
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
