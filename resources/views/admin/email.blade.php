<!-- /resources/views/admin/user.blade.php -->
@extends('layouts.admin')
@section('title', 'Email settings')
@section('content')
<form method="post">
    @foreach ($emails as $email)
        <div style="margin-bottom: 40px;">
            <h4>{{$email->name}}</h4>
            @foreach ($users->get() as $user)
                <div class="input-field">
                    @if ($user->emails->contains($email))
                        <input type="checkbox" name="email[{{$email->id}}][{{$user->id}}]" id="email[{{$email->id}}][{{$user->id}}]" checked="checked" />
                    @else
                        <input type="checkbox" name="email[{{$email->id}}][{{$user->id}}]" />
                    @endif
                    <label for="email[{{$email->id}}][{{$user->id}}]">{{ $user->email }}</label>
                </div>
            @endforeach
        </div>
    @endforeach
    <div class="input-field">
        <button type="submit" class="btn sbs-red">Save</button>
    </div>
</form>
@endsection
