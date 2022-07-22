<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OurTeamController extends Controller
{
    public function index()
    {
        return view('our-team.index');
    }

    public function show(Request $request, $slug)
    {
        return view('our-team.team.' . $slug);
    }
}
