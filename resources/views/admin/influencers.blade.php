<!-- /resources/views/admin/influencers.blade.php -->
@extends('layouts.admin')
@section('title', 'Influencers')
@section('content')
    <div class="row">
        <div class="col s12">
            <h4>Influencers</h4>
        </div>
    </div>
    <form>
        <div class="row m6">
            <div class="col">
                <select name="name">
                    <option value="">Select</option>
                    @foreach($influencers as $influencer)
                        <option value="{{ $influencer->influencer }}" {{ request('name') === $influencer->influencer ? "selected" : "" }}>{{ $influencer->name }}</option>
                    @endforeach
                </select>

            </div>
            <div class="col">
                <button type="submit" class="btn sbs-red" style="width: 100%;">Search</button>
            </div>
        </div>
        <div class="row" style="margin-bottom: 1rem;">
            Signup Link: <a href="{{ URL::to('/') . '/register/' . request('name') }}">{{ URL::to('/') . '/register/' . request('name') }}</a>
        </div>
    </form>


    <div class="row" style="border-bottom: 1px solid #9e9e9e">
        <div class="col l3">
            <strong>User Name</strong>
        </div>
        <div class="col l3">
            <strong>Email</strong>
        </div>
        <div class="col l2">
            <strong>Signup Date</strong>
        </div>
        <div class="col l2">
            <strong>Signed as PRO Member</strong>
        </div>
        <div class="col l2">
            <strong>Current PRO Member</strong>
        </div>
    </div>
    @if (count($users) >0)
        @foreach($users as $user)
            <div class="row">
                <div class="col l3">
                    {{ $user->first_name . ' ' . $user->last_name }}
                </div>
                <div class="col l3">
                    {{ $user->email }}
                </div>
                <div class="col l2">
                    {{ $user->created_at->format('M j, Y') }}
                </div>
                <div class="col l2 center">
                    {{ $user->influencer()->first()->pivot->pro ? 'Yes' : 'No' }}
                </div>
                <div class="col l2 center">
                    {{ $user->roles->contains('clubhouse') ? 'Yes' : 'No' }}
                </div>
            </div>
        @endforeach
    @else
        <div class="col l12 center">
            <h6>No matching records found</h6>
        </div>
    @endif
@endsection
