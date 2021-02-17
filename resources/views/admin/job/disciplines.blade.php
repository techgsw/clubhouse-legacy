<!-- /resources/views/admin/job/disciplines.blade.php -->
@extends('layouts.admin')
@section('title', 'Edit Job Disciplines')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
        </div>
    </div>
    <div class="row">
        <form id="add-job-discipline-form" method="post" action="/tag/add-to-type" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" id="tag-type" name="tag_type" value="job">
            <div class="row">
                <div class="input-field col m8 s12">
                    <label for="tag-autocomplete-input">Job Discipline</label>
                    <input type="text" name="tag_name" id="tag-autocomplete-input" class="tag-autocomplete" required>
                </div>
                <div class="input-field col m4 s12">
                    <button type="submit" class="btn sbs-red" style="min-width:180px;">Add discipline</button>
                </div>
            </div>
        </form>
    </div>
    <div class="row">
        @foreach ($tags as $tag)
            <span class="flat-button gray tag">
                <button type="button" name="button" class="x remove-tag job-discipline-edit" tag-name="{{ $tag->name }}">&times;</button>{{ $tag->name }}
            </span>
        @endforeach
    </div>
</div>
@endsection

