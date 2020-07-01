<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function foo\func;

class Answer extends Model
{
    protected $fillable = [
        'body'
    ];

    //Belongs to user
    public  function user(){
        return $this->belongsTo(User::class);
    }
    //Belongs to question
    public  function question(){
        return $this->belongsTo(Question::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($answer){
            $answer->question->increment('answers_count');
        });

        static::deleted(function($answer){
            $answer->question->decrement('answers_count');
        });
    }
}
