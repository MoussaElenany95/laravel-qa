<?php
namespace App;
Trait VotableTrait{

    // many to many polymorphic relationship (user & answer & question)
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
        return $this->votes;
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
}
