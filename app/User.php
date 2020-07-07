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

        if ($voteQuestions->where('votable_id',$question->id)->exists() )
            $voteQuestions->updateExistingPivot($question,['vote'=>$vote]);
        else
            $voteQuestions->attach($question,['vote'=>$vote]);

        $question->load('votes');
        $upVotes = $question->upVotes();
        $downVotes = $question->downVotes();

        $question->votes_count  = $upVotes + $downVotes;
        $question->save();

    }
    //vote answer
    public function voteAnswer(Answer $answer , $vote){

        $voteAnswers = $this->voteAnswers();

        if($voteAnswers->where('votable_id',$answer->id)->exists() )
            $voteAnswers->updateExistingPivot($answer,['vote'=>$vote]);
        else
            $voteAnswers->attach($answer,['vote'=>$vote]);

        $answer->load('votes');
        $upVotes = (int) $answer->upVotes();
        $downVotes = (int) $answer->downVotes();

        $answer->votes_count  = $upVotes + $downVotes;

        $answer->save();

    }


}
