<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Mentor;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MentorController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view-mentor');

        $mentors = Mentor::with('contact')->paginate(12);
        $tags = Tag::has('mentors')->get();

        return view('mentor/index', [
            'breadcrumb' => [
                'Home' => '/',
                'Mentorship' => "/mentor"
            ],
            'mentors' => $mentors,
            'tags' => $tags
        ]);
    }

    public function show(Request $request, $id)
    {
        $mentor = Mentor::find($id);
        if (!$mentor) {
            return abort(404);
        }
        $this->authorize('view-mentor');

        return view('mentor/show', [
            'breadcrumb' => [
                'Home' => '/',
                'Mentorship' => "/mentor",
                "{$mentor->contact->getName()}" => "/mentor/{$mentor->id}"
            ],
            'mentor' => $mentor
        ]);
    }

    public function edit(Request $request, $id)
    {
        $this->authorize('edit-mentor');

        $contact = Contact::with('mentor')->find($id);
        if (!$contact || !$contact->mentor) {
            return abort(404);
        }

        return view('contact/mentor', [
            'breadcrumb' => [
                'Home' => '/',
                'Mentorship' => "/mentor",
                "{$contact->getName()}" => "/contact/{$contact->id}/mentor"
            ],
            'contact' => $contact
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('edit-mentor');

        $mentor = Mentor::find($id);
        if (!$mentor) {
            return abort(404);
        }

        $mentor->description = request('description');
        $mentor->active = request('active') === '1';
        $mentor->save();

        return redirect()->action('MentorController@edit', [$mentor->contact_id]);
    }

    public function addTag(Request $request, $id)
    {
        $this->authorize('edit-mentor');

        $mentor = Mentor::find($id);
        if (!$mentor) {
            return redirect()->back()->withErrors(['msg' => 'Could not find mentor ' . $id]);
        }

        try {
            DB::transaction(function () use ($mentor, $request) {
                $name = $request->name;
                $tag = Tag::where('name', $name)->first();
                if (empty($tag)) {
                    // Create tag
                    $slug = preg_replace("/(\s+)/", "-", strtolower($name));
                    $tag = Tag::create([
                        'name' => $name,
                        'slug' => $slug
                    ]);
                }

                $mentor->tags()->attach($name);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function removeTag(Request $request, $id)
    {
        $this->authorize('edit-mentor');

        $mentor = Mentor::find($id);
        if (!$mentor) {
            return redirect()->back()->withErrors(['msg' => 'Could not find mentor ' . $id]);
        }

        try {
            DB::transaction(function () use ($mentor, $request) {
                $tag = Tag::where('slug', request('slug'))->first();
                if (empty($tag)) {
                    return;
                }

                $mentor->detach($name);
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'success' => false
            ]);
        }

        return response()->json([
            'success' => true
        ]);
    }
}
