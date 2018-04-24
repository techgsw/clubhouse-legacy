<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // TODO $this->authorize('view-contact');

        $images = Image::orderBy('id', 'desc');
        $count = $images->count();
        $images = $images->paginate(60);

        return view('admin/image', [
            'images' => $images,
            'count' => $count
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        // TODO $this->authorize('view-contact');

        $image = Image::find($id);
        if (!$image) {
            return abort(404);
        }

        return view('image/show', [
            'image' => $image
        ]);
    }
}
