<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteAnswerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function __invoke(Answer $answer , Request $request)
    {
       $vote = $request->vote;
       $user = Auth::user();

       $user->voteAnswer($answer,$vote);

       return back();
    }
}
