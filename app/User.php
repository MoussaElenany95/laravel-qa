<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $appends = ['url','avatar'];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function getUrlAttribute(){
        return "#";
    }
    //get avatar
    public function getAvatarAttribute(){
        $email = $this->email;
        $size = 40;
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?s=" . $size;
    }
    // one to many relationship between questions
    public function questions(){
        return $this->hasMany(Question::class);

    }
    // one to many relationship between answers
    public  function answers(){
        return $this->hasMany(Answer::class);
    }
    // many to many relationship between questions
    public function favorites(){

        return $this->belongsToMany(Question::class,'favorites');
    }
    // many to many polymorphic relationship (question & answer)
    public function voteQuestions(){
        return $this->morphedByMany(Question::class,'votable');
    }
    public function voteAnswers(){
        return $this->morphedByMany(Answer::class,'votable');
    }
    //vote question
    public function voteQuestion(Question $question , $vote){

        $voteQuestions = $this->voteQuestions();

        $this->_vote($voteQuestions,$question,$vote);

    }
    //vote answer
    public function voteAnswer(Answer $answer , $vote){

        $voteAnswers = $this->voteAnswers();
        $this->_vote($voteAnswers,$answer,$vote);

    }
    private function _vote($questionOrAnswer , $model , $vote){


        if($questionOrAnswer->where('votable_id',$model->id)->exists() )
            $questionOrAnswer->updateExistingPivot($model,['vote'=>$vote]);
        else
            $questionOrAnswer->attach($model,['vote'=>$vote]);

        $model->load('votes');
        $upVotes = (int) $model->upVotes();
        $downVotes = (int) $model->downVotes();

        $model->votes_count  = $upVotes + $downVotes;

        $model->save();
    }


}
