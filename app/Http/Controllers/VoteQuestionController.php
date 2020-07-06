<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function __invoke(Question $question,Request $request){

        $vote = $request->vote;
        $user = Auth::user();

        $user->voteQuestion($question,$vote);

        return back();
    }
}
