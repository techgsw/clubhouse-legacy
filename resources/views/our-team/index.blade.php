@extends('layouts.clubhouse')
@section('title', 'Our Team')
@section('content')
<div class="container">
    <div class="row" style="padding: 30px 30px;">
        <div class="col s12 m12">
            <h5><strong>Our Team</strong></h5>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
        </div>
        <div class="row center-align">
            <div class="row s12 m12 l12 center-align">
                <a href="/our-team/lou-de-paoli">
                    <div class="col s12 m6 l3 center-align">
                        <img src="/images/same-here/lou-de-paoli.png" class="profile-pic">
                        <h5>
                            Lou De Paoli
                            <span class="about-position">Managing Director</span>
                            <span class="about-position sbs-red-text">General Sports Worldwide</span>
                        </h5>
                    </div>
                </a>
                <a href="/our-team/travis-apple">
                    <div class="col s12 m6 l3 center-align">
                        <img src="/images/same-here/travis-apple.png" class="profile-pic">
                        <h5>
                            Travis Apple
                            <span class="about-position">Vice President</span>
                            <span class="about-position sbs-red-text">General Sports Worldwide</span>
                        </h5>
                    </div>
                </a>
                <a href="/our-team/jentry-mullins">
                    <div class="col s12 m6 l3 center-align">
                        <img src="/images/same-here/jentry-mullins.png" class="profile-pic">
                        <h5>
                            Jentry Mullins
                            <span class="about-position">Senior Director</span>
                            <span class="about-position sbs-red-text">General Sports Worldwide</span>
                        </h5>
                    </div>
                </a>
                <a href="/our-team/kayla-lawson">
                    <div class="col s12 m6 l3 center-align">
                        <img src="/images/same-here/kayla-lawson.png" class="profile-pic">
                        <h5>
                            Kayla Lawson
                            <span class="about-position">Manager</span>
                            <span class="about-position sbs-red-text">General Sports Worldwide</span>
                        </h5>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
