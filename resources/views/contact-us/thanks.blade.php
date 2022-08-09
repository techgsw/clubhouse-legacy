@extends('layouts.default')
@section('title', 'Contact')
@section('content')
<div class="container center">
    <h3 class="header">Thank you!</h3>
    <div class="row">
        <div class="col s12">
            <p>Your inquiry has been received. Someone from the {{ __('general.company_name') }} team will be in touch with you within two business days.</p>
        </div>
    </div>
    <div class="row">
        <a href="/" class="btn btn-large sbs-red">Return to {{ __('general.company_name') }}</a>
    </div>
</div>
@endsection
