<!-- /resources/views/admin/user.blade.php -->
@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<h4>Users</h4>
<form class="" action="/admin/user" method="get">
    <div class="row">
        <div class="col input-field s12 m8">
            <i class="material-icons prefix">search</i>
            <input id="search_term" type="text" name="term" value="{{ request('term') }}">
            <label for="search_term">Name or Email</label>
        </div>
        <div class="col input-field s12 m4 center-align">
            <select class="browser-default" name="sort">
                <option value="id-asc" {{ request('sort') == "id-asc" ? "selected" : "" }}>ID (low to high)</option>
                <option value="id-desc" {{ request('sort') == "id-desc" ? "selected" : "" }}>ID (high to low)</option>
                <option value="email-asc" {{ request('sort') == "email-asc" ? "selected" : "" }}>Email (A to Z)</option>
                <option value="email-desc" {{ request('sort') == "email-desc" ? "selected" : "" }}>Email (Z to A)</option>
                <option value="name-asc" {{ request('sort') == "name-asc" ? "selected" : "" }}>Name (A to Z)</option>
                <option value="name-desc" {{ request('sort') == "name-desc" ? "selected" : "" }}>Name (Z to A)</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col input-field s12 center-align">
            <button type="submit" name="submit" class="btn sbs-red">Search</button>
        </div>
    </div>
</form>
<div class="row">
    <div class="col s12">
        @if (count($users) > 0)
            @foreach ($users as $user)
                <a href="/user/{{ $user->id }}">
                    <div class="row">
                        <div class="col s3 l2">
                            @if ($user->profile->headshot_url)
                                <img src={{ Storage::disk('local')->url($user->profile->headshot_url) }} style="width: 80%; max-width: 100px; border-radius: 50%;" />
                            @else
                                <i class="material-icons large">person</i>
                            @endif
                        </div>
                        <div class="col s9 l10">
                            <div class="row">
                                <div class="col s12 m6">
                                    <h5>{{ $user->getName() }}</h5>
                                    <p>{{ $user->email }}</p>
                                </div>
                                <div class="col s12 m6">
                                    <p>#{{ $user->id }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
            <div class="row">
                <div class="col s12 center-align">
                    {{ $users->links('components.pagination') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
