<?php


Route::get('/','QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/users/{username}','UserController@show')->name('user.profile');

Route::resource('questions','QuestionsController')->except('show');
Route::resource('questions.answers','AnswersController');

Route::post('/answers/{answer}/accept','AcceptAnswerController')->name('answers.accept');
Route::post('/answers/{answer}/vote','VoteAnswerController')->name('answers.vote');
Route::post('/questions/{question}/favorite','FavoriteQuestionController')->name('questions.favorite');
Route::post('/questions/{question}/vote','VoteQuestionController')->name('questions.vote');
Route::get('/questions/{slug}','QuestionsController@show')->name('questions.show');

