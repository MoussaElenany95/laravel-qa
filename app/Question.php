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
    // many to many relationship between users
    public function favorites(){
        return $this->belongsToMany(User::class,'favorites')->withTimestamps();
    }
    // many to many polymorphic relationship (user & answer)
    public function votes(){
        return $this->morphToMany(User::class,'votable');
    }
    //Up votes
    public function upVotes(){
        return $this->votes()->wherePivot('vote',1)->sum('vote');
    }
    //Down votes
    public function downVotes(){
        return $this->votes()->wherePivot('vote',-1)->sum('vote');
    }
    //is VottedUp
    public function isVottedUp(){
        return $this->votes()->where(['user_id'=> auth()->id() ,'vote'=> 1 ])->exists();
    }
    //is VottedDown
    public function isVottedDown(){
        return $this->votes()->where(['user_id'=> auth()->id() ,'vote'=> -1 ])->exists();
    }
    public function getVottedUpAttribute(){
        return $this->isVottedUp();
    }
    public function getVottedDownAttribute(){
        return $this->isVottedDown();
    }
    // is favoritted
    public function isFavorited(){

        return $this->favorites()->where('user_id', auth()->id() )->count() > 0 ;
    }
    public function getFavorittedAttribute(){
        return $this->isFavorited();
    }
    public function getFavoritesCountAttribute(){
        return $this->favorites()->count();
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
