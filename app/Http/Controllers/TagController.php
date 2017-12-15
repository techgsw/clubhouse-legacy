<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Message;
use App\Http\Requests\StoreTag;
use App\Providers\ImageServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Parsedown;
use \Exception;

class TagController extends Controller
{
    /**
     * @param  StoreTag  $request
     * @return Response
     */
    public function store(StoreTag $request)
    {
        $this->authorize('create-tag');

        $name = $request->name;
        $slug = preg_replace("/(\s+)/", "-", strtolower($name));

        try {
            $tag = Tag::create([
                'name' => $name,
                'slug' => $slug,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if ($e->getCode() === '23000') {
                $message = "Oops! That tag already exists.";
            } else {
                $message = "Sorry, we were unable to create that tag. Please contact support.";
            }
            $request->session()->flash('message', new Message(
                $message,
                "danger",
                $code = null,
                $icon = "error"
            ));
            return response()->json([
                'error' => $message,
                'tag' => null
            ]);
        }

        return response()->json([
            'error' => null,
            'tag' => $tag
        ]);
    }

    /**
     * @param  string $title_url
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        $tags = Tag::all();
        return response()->json($tags);
    }
}
