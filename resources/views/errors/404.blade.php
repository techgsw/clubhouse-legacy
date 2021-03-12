@extends(Request::root() == env('CLUBHOUSE_URL') ? 'layouts.clubhouse' : 'layouts.default')
@section('title', 'Page Not Found')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            @include('layouts.components.messages')
            @include('layouts.components.errors')
            <h3 class="header">Oops!</h3>
            <p class="light">The page you're looking for cannot be found.</p>
        </div>
    </div>
</div>
@endsection
