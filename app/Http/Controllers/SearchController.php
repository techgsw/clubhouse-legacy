<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;

class SearchController
{
    public function state(Request $request)
    {
        $result = [];

        $search = $request['term'];

        if ($search) {
            $states = State::where('abbrev', 'LIKE', $search . '%')
                ->orWhere('state', 'LIKE', $search . '%')
                ->get();

            $result = $states->toArray();
        }

        return response()->json($result);
    }
}
