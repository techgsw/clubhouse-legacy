<?php

namespace App\Http\Controllers;

use App\League;
use App\Providers\ImageServiceProvider;
use App\Http\Requests\League\Store;
use App\Http\Requests\League\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use \Exception;

class LeagueController extends Controller
{
    public function store(Store $request) {
        $this->authorize('create-league');

        $name = $request->name;
        $code = UtilityServiceProvider::encode($name);

        $league = League::where('code', $code)->first();
        if ($league->count() == 0) {
            $league = League::create([
                'name' => $name,
                'code' => $code
            ]);
        }

        return response()->json([
            'league' => $league
        ]);
    }

    public function all()
    {
        $this->authorize('view-league');

        return response()->json([
            'organizations' => League::all()
        ]);
    }
}
