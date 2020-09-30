@extends('layouts.admin')
@section('title', 'Clubhouse PRO Users')
@section('content')
@include('layouts.components.messages')
<div class="row">
    <div class="col s12">
        <h5><strong style="margin-bottom:10px;"><span class="sbs-red-text">{{ count($clubhouse_users) }}</span> Active Clubhouse {{$is_clubhouse_collaborators ? 'Collaborators' : 'PRO Users'}}</strong>
            &nbsp;&nbsp;
        <a href="{{env('CLUBHOUSE_URL')}}/admin/report/clubhouse{{$is_clubhouse_collaborators ? '' : '?is_clubhouse_collaborators=true'}}" class="flat-button {{$is_clubhouse_collaborators ? 'inverse' : ''}} btn-small" style="margin-bottom:10px;"><i class="fa {{$is_clubhouse_collaborators ? 'fa-check-square-o' : 'fa-square-o' }} icon-left"></i> Clubhouse Collaborators</a>
        <a href="{{env('CLUBHOUSE_URL')}}/admin/report/clubhouse/download{{$is_clubhouse_collaborators ? '?is_clubhouse_collaborators=true' : ''}}" class="btn sbs-red" style="float:right;"><i class="fa fa-download icon-left"></i> Download</a>
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
                    @if(!$is_clubhouse_collaborators)
                        <th>Manually Added</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($clubhouse_users as $user)
                    <tr>
                        <td>{{ $user->date }}</td>
                        <td><a href="/user/{{ $user->user_id }}">{{ $user->first_name }} {{ $user->last_name }}</a></td>
                        <td><a href="mailto: {{ $user->email }}">{{ $user->email }}</a></td>
                        @if(!$is_clubhouse_collaborators)
                            <td>
                                @if($user->manually_added)
                                    <i class="fa fa-check"></i>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
