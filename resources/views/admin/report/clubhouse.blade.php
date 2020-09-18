@extends('layouts.admin')
@section('title', 'Clubhouse PRO Users')
@section('content')
@include('layouts.components.messages')
<div class="row">
    <div class="col s12">
        <h5><strong><span class="sbs-red-text">{{ count($clubhouse_users) }}</span> Active Clubhouse PRO Users</strong>
        <a href="{{env('CLUBHOUSE_URL')}}/admin/report/clubhouse/download" class="btn sbs-red" style="float:right;"><i class="fa fa-download icon-left"></i> Download</a>
        </h5>
    </div>
</div>
<div class="row">
    <div class="col s12">
        <table class="responsive-table striped">
            <thead>
                <tr>
                    <th>Activation Date</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Manually Added</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clubhouse_users as $user)
                    <tr>
                        <td>{{ $user->date }}</td>
                        <td><a href="/user/{{ $user->user_id }}">{{ $user->first_name }} {{ $user->last_name }}</a></td>
                        <td><a href="mailto: {{ $user->email }}">{{ $user->email }}</a></td>
                        <td>
                            @if($user->manually_added)
                                <i class="fa fa-check"></i>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
