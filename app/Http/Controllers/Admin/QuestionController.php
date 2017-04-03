<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unapproved = Question::unapproved()->paginate(5);

        return view('admin/question', [
            'unapproved' => $unapproved
        ]);
    }
}
