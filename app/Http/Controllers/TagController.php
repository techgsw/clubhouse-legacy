<?php

namespace App\Http\Controllers;

use App\JobTagWhiteList;
use App\Tag;
use App\TagType;
use App\Message;
use App\Http\Requests\StoreTag;
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

    /**
     * Return all tags for blog posts
     * @return \Illuminate\Http\Response
     */
    public function posts(Request $request)
    {
        $tags = Tag::has('posts')->get();
        return response()->json($tags);
    }

    /**
     * Return all tags for mentors
     * @return \Illuminate\Http\Response
     */
    public function mentors(Request $request)
    {
        $tags = Tag::has('mentors')->get();
        return response()->json($tags);
    }

    /**
     * Return all tags for jobs
     * @return \Illuminate\Http\Response
     */
    public function jobs(Request $request)
    {
        $whiteList = JobTagWhiteList::all()
            ->pluck('tag_name')
            ->toArray();
        $tags = Tag::whereHas('tagType', function($query) use ($whiteList) {
            $query->where('type', 'job')
                ->whereIn('tag_name', $whiteList);
        })->get();

        return response()->json($tags);
    }

    public function addToType(Request $request)
    {
        $this->authorize('create-tag-type');

        $tag_name = $request->tag_name;
        $type = $request->tag_type;

        try {
            Tag::firstOrCreate([
                'name' => $tag_name,
                'slug' => preg_replace("/(\s+)/", "-", strtolower($tag_name))
            ]);

            TagType::create([
                'tag_name' => $tag_name,
                'type' => $type,
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            if ($e->getCode() === '23000') {
                $message = "Oops! That already exists.";
            } else {
                $message = "We were unable to create that tag type. Please contact support.";
            }
            return redirect()->back()->withErrors($message);
        }

        return redirect()->back();
    }

    public function deleteFromType(Request $request)
    {
        $this->authorize('delete-tag-type');

        $tag_name = $request->tag_name;
        $type = $request->type;

        $tag_type = TagType::where('tag_name', $tag_name)
            ->where('type', $type)->first();

        if (!$tag_type) {
            return response()->json([
                'message' => 'Unable to find requested tag. Please reload the page or contact support if error continues.',
                'type' => 'danger'
            ]);
        }

        $tag_type->delete();

        //TODO ideally we shouldn't have to use conditionals to pull relations
        //     but calling relation functions using a string seems kludgy
        if ($type == 'job') {
            $tags = Tag::whereHas('jobs')->where('name', $tag_name)->get();
            foreach ($tags as $tag) {
                $tag->jobs()->detach();
            }
        } else {
            return response()->json([
                'message' => 'The requested tag type is not supported, please contact support',
                'type' => 'danger'
            ]);
        }

        return response()->json([
            'message' => 'Success! Tag deleted from '.$tag_type.' type.',
            'type' => 'success'
        ]);
    }
}
