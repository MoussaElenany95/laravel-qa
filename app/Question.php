<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $fillable = ['title','body'];

    // one to many relationship between user table
    public  function user(){
        return $this->belongsTo(User::class);
    }
    // one to many relationship between answers
    public  function answers(){
        return $this->hasMany(Answer::class);
    }
    //set attributes for question
    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value,'-');
    }
    //get question url
    public function getUrlAttribute(){
        return route('questions.show',$this->slug);
    }
    //get question date
    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }
    //get question status
    public function getStatusAttribute(){
        if($this->answers_count > 0){
            if($this->best_answer_id)
                return "answer-accepted";
            return "answered";
        }
        return "unanswered";
    }
    //get question body if it has html code
    public function getBodyHtmlAttribute(){
        return \Parsedown::instance()->text($this->body);
    }
    //Accept best answer
    public function acceptBestAnswer(Answer $answer){
        if( $this->best_answer_id != $answer->id )

            $this->best_answer_id = $answer->id;

        else
            $this->best_answer_id = NULL;         //Undo accept answer


        $this->save();
    }

}
