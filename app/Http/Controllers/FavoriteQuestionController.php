<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class FavoriteQuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function __invoke(Question $question)
    {
       if($question->isFavorited()){

           $question->favorites()->detach(auth()->id());

       }else{

           $question->favorites()->attach(auth()->id());

       }
       return back();
    }
}
