<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
