<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return password_hash("123456789",PASSWORD_DEFAULT);
   // return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions','QuestionsController')->except('show');
Route::resource('questions.answers','AnswersController');

Route::post('/answers/{answer}/accept','AcceptAnswerController')->name('answers.accept');
Route::post('/answers/{answer}/vote','VoteAnswerController')->name('answers.vote');
Route::post('/questions/{question}/favorite','FavoriteQuestionController')->name('questions.favorite');
Route::post('/questions/{question}/vote','VoteQuestionController')->name('questions.vote');
Route::get('/questions/{slug}','QuestionsController@show')->name('questions.show');
