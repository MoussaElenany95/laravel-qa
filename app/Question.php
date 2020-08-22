<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{

    use VotableTrait;

    protected $fillable = ['title','body'];
    protected $appends = ['url','created_date','favorites_count','status','favoritted','votted_up','votted_down','body_html'];
    // one to many relationship between user table
    public  function user(){
        return $this->belongsTo(User::class);
    }
    // one to many relationship between answers
    public  function answers(){
        return $this->hasMany(Answer::class)->orderBy('votes_count','desc');
    }
    // many to many relationship between users
    public function favorites(){
        return $this->belongsToMany(User::class,'favorites')->withTimestamps();
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
        $body = \Parsedown::instance()->text($this->body);
        return strip_tags($body);
    }
    //Accept best answer
    public function acceptBestAnswer(Answer $answer){
        $accept = false;
        if( $this->best_answer_id != $answer->id ) {

            $this->best_answer_id = $answer->id;
            $accept = true;
        }
        else
            $this->best_answer_id = NULL;         //Undo accept answer

        $this->save();

        return $accept;
    }

}
