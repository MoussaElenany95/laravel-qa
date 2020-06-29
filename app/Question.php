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
    //set attributes for question
    public function setTitleAttribute($value){
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value,'-');
    }
    //get question url
    public function getUrlAttribute(){
        return route('questions.show',$this->id);
    }
    //get question date
    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }
    //get question status
    public function getStatusAttribute(){
        if($this->answers > 0){
            if($this->best_answer_id)
                return "answer-accepted";
            return "answered";
        }
        return "unanswered";
    }
}
