<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Influencer;
use App\Message;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class InfluencersController extends Controller
{
    public function index(Request $request)
    {
        $influencers = Influencer::all();
        $influencerName = $request['name'];
        $users = User::whereHas('influencer', function($query) use ($influencerName) {
            $query->where('influencer', $influencerName);
        })->orderBy('created_at', 'DESC')->get();

        return view('admin.influencers', ['influencers' => $influencers, 'users' => $users]);
    }

    public function store(Request $request)
    {
        Influencer::create($request->all());

        return redirect()->route('admin.influencers', ['name' => request('influencer')]);
    }
}
