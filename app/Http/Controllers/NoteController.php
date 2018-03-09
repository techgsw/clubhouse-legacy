<?php

namespace App\Http\Controllers;

use App\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use \Exception;

class NoteController extends Controller
{
    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->authorize('delete-note');

        $note = Note::find($id);
        if (!$note) {
            return response()->json([
                'error' => "Failed to find note {$id}"
            ]);
        }

        try {
            $note->delete();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => "Failed to delete note {$id}"
            ]);
        }

        return response()->json([
            'error' => null
        ]);
    }
}
