@extends('layouts.clubhouse')
@section('title', 'Clubhouse Pricing')
@section('hero')
    <div class="row hero bg-image services">
        <div class="col s12">
            <h4 class="header">Clubhouse</h4>
            <p>Welcome to the Clubhouse. Take a look below to checkout our product offerings.</p>
        </div>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12 center-align">
                <h5>There are many opportunities when it comes to careers in sports. That's why we've gathered all possiblities just for you.</h5>
            </div>
        </div>
        <div class="row">
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12 center-align" style="padding: 10px 0 50px 0;">
                            <p><strong>Offering one</strong></p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            <a href="/job" class="btn sbs-red" style="margin-top: 20px;"> Get started</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12 center-align" style="padding: 10px 0 50px 0;">
                            <p><strong>Offering two</strong></p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            <a href="/job" class="btn sbs-red" style="margin-top: 20px;"> Checkout now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m4">
                <div class="card">
                    <div class="card-content center-align" style="display: flex; flex-flow: column; justify-content: space-between;">
                        <div class="col s12 center-align" style="padding: 10px 0 50px 0;">
                            <p><strong>Offering three</strong></p>
                        </div>
                        <div class="col s12 center-align" style="padding-bottom: 10px;">
                            <a href="/job" class="btn sbs-red" style="margin-top: 20px;"> Checkout now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
