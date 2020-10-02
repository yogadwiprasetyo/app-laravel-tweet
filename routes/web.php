<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Web Routes Tweet
Route::get('/tweet/{id}', 'TweetController@show')->name('tweet.show');
Route::post('/tweet/posting', 'TweetController@store')->name('tweet.store');
Route::put('/tweet/{id}', 'TweetController@update')->name('tweet.update');
Route::delete('/tweet/{id}', 'TweetController@destroy')->name('tweet.delete');

// Web Routes Reply and Like Tweet
Route::post('/tweet/{id}/reply', 'ComponentTweetController@storeReply')->name('reply.store');
Route::post('/tweet/{id}/like', 'ComponentTweetController@storeLikes')->name('like.store');
Route::put('/reply/{id}', 'ComponentTweetController@updateReply')->name('reply.update');
Route::delete('/reply/{id}', 'ComponentTweetController@destroyReply')->name('reply.delete');

// Web Routes Profile
Route::get('/profile/{id}/password', 'ProfileController@change')->middleware('password.confirm')->name('profile.change');
Route::get('/profile/{id}', 'ProfileController@index')->name('profile.index');
Route::get('/create', 'ProfileController@create')->name('profile.create');
Route::get('/profile/{id}/edit', 'ProfileController@edit')->name('profile.edit');
Route::post('/changepassword/{id}', 'ProfileController@changePassword')->name('profile.password');
Route::post('/profile', 'ProfileController@store')->name('profile.store');
Route::put('/profile/{id}', 'ProfileController@update')->name('profile.update');