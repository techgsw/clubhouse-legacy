@extends('layouts.admin')
@section('title', 'User Profile Update')
@section('content')
<form action="">
    <div class="row">
        <div class="col s12 m4">
            <div class="form-group">
                <input class="drp center-align" type="text" name="date_range" id="date-range" />
                <input class="hidden" type="text" name="date_range_start" id="date-range-start" value="{{ $start_date->format('Y-m-d') }}"/>
                <input class="hidden" type="text" name="date_range_end" id="date-range-end" value="{{ $end_date->format('Y-m-d') }}"/>
            </div>
        </div>
    </div>
</form>
@include('layouts.components.messages')
<div class="row">
    <div class="col s12">
        <h5><strong>User Profile Updates</strong></h5>
    </div>
</div>
<div class="row">
    <div class="col s12">
        <table class="responsive-table striped">
            <thead>
            <tr>
                <th>Updated</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Alt. Phone</th>
                <th>PRO Member</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($profiles as $profile)
                <tr>
                    <td>{{ $profile->updated_at->format('F j, Y g:i A') }}</td>
                    <td><a href="/user/{{ $profile->user->id }}">{{ $profile->user->first_name }} {{ $profile->user->last_name }}</a></td>
                    <td>{{ $profile->user->email }}</td>
                    <td class="right-align">@if($profile->user->contact->phone){{ $profile->user->contact->phoneFormatted() }}@endif</td>
                    <td class="right-align">@if($profile->user->contact->secondary_phone){{ $profile->user->contact->phoneFormatted('secondary_phone') }}@endif</td>
                    <td class="center-align">{{ $profile->user->hasRole('clubhouse') ? 'Yes' : 'No' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col s12 center-align">
            {{ $profiles->appends(request()->all())->links('components.pagination') }}
        </div>
    </div>
</div>
@endsection
