<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function foo\func;

class Answer extends Model
{
    protected $fillable = [
        'body','user_id'
    ];

    //Belongs to user
    public  function user(){
        return $this->belongsTo(User::class);
    }
    //Belongs to question
    public  function question(){
        return $this->belongsTo(Question::class);
    }
    //get answer date
    public function getCreatedDateAttribute(){
        return $this->created_at->diffForHumans();
    }
    //get answer body if it has html code
    public function getBodyHtmlAttribute(){
        return \Parsedown::instance()->text($this->body);
    }
    //answer accepted or not
    public function getStatusAttribute(){
        return $this->id == $this->question->best_answer_id ? 'vote-accepted' : '' ;
    }
    public static function boot()
    {
        parent::boot();
        //when create answer make answers count + 1
        static::created(function($answer){
            $answer->question->increment('answers_count');
        });

        static::deleted(function($answer){
            $answer->question->decrement('answers_count');
        });
    }
}
