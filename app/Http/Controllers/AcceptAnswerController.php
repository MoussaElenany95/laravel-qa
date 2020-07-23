<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class AcceptAnswerController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function __invoke(Answer $answer)
    {
        $this->authorize('accept',$answer);
        $answer->question->acceptBestAnswer($answer);

        if (\request()->expectsJson()){
            return response()->json(null,204);
        }
        return back();
    }
}
