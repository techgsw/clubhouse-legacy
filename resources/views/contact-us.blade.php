@extends('layouts.default')
@section('title', 'Contact')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
        </div>
    </div>
</div>
@include('contact-us.form', ['errors' => $errors])
@endsection
