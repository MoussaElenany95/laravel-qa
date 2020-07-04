<?php

namespace App\Http\Controllers;

use App\Http\Requests\AskQuestionRequest;
use App\Question;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=> ['index','show']]);
    }
    public function index()
    {
        $questions = Question::with('user')->latest()->paginate(10);
        return view('questions.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();
        return  view('questions.create',compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
       $request->user()->questions()->create($request->only('title','body'));
       return  redirect()->route('questions.index')->with('success','your question has been submitted');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question->increment('views');
        return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //Authorization using gates
       /* if (Gate::denies('update-question',$question)){
            abort(403);
        }*/
        if(!$this->authorize('update',$question)){
            abort(403);
        }
        return view('questions.edit',compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, Question $question)
    {
        if(!$this->authorize('update',$question)){
            abort(403);
        }
        //update question
        $question->update(

            $request->validate([

                'title'=>'required|max:255|unique:questions,title,'.$question->id,
                'body'=>'required',
            ])
        );
        return  redirect()->route('questions.index')->with('success','Your question has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //Authorization using gates
        /* if (Gate::denies('delete-question',$question)){
             abort(403);
         }*/
        if(!$this->authorize('delete',$question)){
            abort(403);
        }
        $question->delete();
        return  redirect()->route('questions.index')->with('success','Your question has been deleted');
    }
}
