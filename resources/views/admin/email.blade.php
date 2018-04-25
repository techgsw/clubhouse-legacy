<!-- /resources/views/admin/user.blade.php -->
@extends('layouts.admin')
@section('title', 'Email settings')
@section('content')
@include('layouts.components.messages')
<form method="post" action="/email/update">
    {{ csrf_field() }}
    <div class="card-flex-container">
        @foreach ($users as $user)
            <div class="card">
                <div class="card-content">
                    <span class="card-title" style="font-size: 20px;">{{ $user->getName() }}</span>
                    @foreach ($emails as $email)
                        <div>
                            @if ($user->emails->contains($email))
                                <input type="checkbox" name="user[{{$user->id}}][{{$email->id}}]" id="user[{{$user->id}}][{{$email->id}}]" checked="checked" />
                            @else
                                <input type="checkbox" name="user[{{$user->id}}][{{$email->id}}]" id="user[{{$user->id}}][{{$email->id}}]" />
                            @endif
                            <label for="user[{{$user->id}}][{{$email->id}}]">{{ $email->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
        <div class="card-placeholder"></div>
        <div class="card-placeholder"></div>
        <div class="card-placeholder"></div>
        <div class="card-placeholder"></div>
        <div class="card-placeholder"></div>
        <div class="card-placeholder"></div>
    </div>
    <div class="input-field">
        <button type="submit" class="btn sbs-red">Save</button>
    </div>
</form>
@endsection
