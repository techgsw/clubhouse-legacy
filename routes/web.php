<?php

/**
 * Static
 */

Route::get('/', function () {
    return view('home');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/contact', function () {
    return view('contact');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/services', function () {
    return view('services');
});
Route::get('/blog', function () {
    return redirect('https://blog.sportsbusiness.solutions/');
});

/**
 * Auth
 */

Route::group(['namespace' => 'Auth'], function () {
    // namespace App\Http\Controllers\Auth
    Route::get('login', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
});

/**
 * User Profile
 */

Route::group(['middleware' => ['auth']], function () {
    Route::get('/user/{id}', 'UserController@show');
    Route::get('/user/{id}/edit', 'UserController@edit');
    Route::patch('/user/{id}', 'UserController@update');
});

/**
 * Q&A
 */

Route::group(['middleware' => ['auth']], function () {
    Route::get('/question', 'QuestionController@index');
    Route::get('/question/create', 'QuestionController@create');
    Route::post('/question', 'QuestionController@store');
    Route::get('/question/{id}', 'QuestionController@show');
    Route::get('/question/{id}/edit', 'QuestionController@edit');
    Route::post('/question/{id}', 'QuestionController@update');
    //Route::delete('/question/{id}', 'QuestionController@destroy');
    Route::get('/question/{id}/answer', 'AnswerController@create');
    Route::post('/question/{id}/answer', 'AnswerController@store');
    Route::get('/answer/{id}/edit', 'AnswerController@edit');
    Route::post('/answer/{id}', 'AnswerController@update');
    //Route::delete('/answer/{id}', 'AnswerController@destroy');
});

/**
 * SalesCenter
 */

Route::group(['namespace' => 'SalesCenter'], function () {
    // namespace App\Http\Controllers\SalesCenter
});

/**
 * Admin
 */

Route::group(['namespace' => 'Admin', 'middleware' => ['web']], function () {
    // namespace App\Http\Controllers\Admin
});

Auth::routes();
