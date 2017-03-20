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
Route::get('/services', function () {
    return view('services');
});
Route::get('/contact', function () {
    return view('contact');
});
Route::get('/register', function () {
    return redirect('sales-center');
});
Route::get('/sales-center', function () {
    return view('sales-center');
});
Route::get('/blog', function () {
    return redirect('https://blog.sportsbusiness.solutions/');
});

/**
 * Auth
 */

Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
});
Auth::routes();

/**
 * User
 */

Route::group(['middleware' => ['auth']], function () {
    Route::get('/user/{id}', 'UserController@show');
    Route::get('/user/{id}/edit', 'UserController@edit');
    Route::post('/user/{id}', 'UserController@update');
});

/**
 * Job Board
 */

Route::group(['middleware' => ['auth']], function () {
    Route::get('/job', function () {
        return view('job/index');
    });
    /*
    Route::get('/job', 'JobController@index');
    Route::get('/job/create', 'JobController@create');
    Route::post('/job', 'JobController@store');
    Route::get('/job/{id}', 'JobController@show');
    Route::get('/job/{id}/edit', 'JobController@edit');
    Route::post('/job/{id}', 'JobController@update');
    Route::delete('/job/{id}', 'JobController@destroy');
    */
});

/**
 * Q&A
 */

Route::group(['middleware' => ['auth']], function () {
    Route::get('/question', 'QuestionController@index');
    Route::get('/question/create', 'QuestionController@create');
    Route::post('/question', 'QuestionController@store');
    Route::get('/question/{id}', 'QuestionController@show');
    Route::get('/question/{id}/approve', 'QuestionController@approve');
    Route::get('/question/{id}/disapprove', 'QuestionController@disapprove');
    Route::get('/question/{id}/edit', 'QuestionController@edit');
    Route::post('/question/{id}', 'QuestionController@update');
    //Route::delete('/question/{id}', 'QuestionController@destroy');
    Route::post('/question/{id}/answer', 'AnswerController@store');
    Route::get('/answer/{id}/approve', 'AnswerController@approve');
    Route::get('/answer/{id}/disapprove', 'AnswerController@disapprove');
    Route::get('/answer/{id}/edit', 'AnswerController@edit');
    Route::post('/answer/{id}', 'AnswerController@update');
    //Route::delete('/answer/{id}', 'AnswerController@destroy');
});

/**
 * Admin
 */

Route::group(['namespace' => 'Admin', 'middleware' => ['auth', 'web']], function () {

});
