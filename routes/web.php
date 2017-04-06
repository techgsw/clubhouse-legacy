<?php

/**
 * Static
 */

Route::get('/', function () {
    return view('index');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/services', function () {
    return view('services');
});
Route::get('/register', function () {
    return redirect('sales-center');
});
Route::get('/blog', function () {
    return redirect('https://blog.sportsbusiness.solutions/');
});
Route::get('/video', function () {
    return redirect('videos');
});
Route::get('/videos', function () {
    return view('videos');
});

/**
 * The Hub
 */
Route::get('/the-hub', 'HubController@index');

/**
 * Contact
 */
Route::get('/contact', 'ContactController@index');
Route::post('/contact', 'ContactController@send');
Route::get('/contact/thanks', 'ContactController@thanks');

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
Route::group(['middleware' => ['web']], function () {
    Route::get('/job', 'JobController@index');
    Route::get('/job/create', 'JobController@create');
    Route::post('/job', 'JobController@store');
    Route::get('/job/{id}', 'JobController@show');
    Route::get('/job/{id}/open', 'JobController@open');
    Route::get('/job/{id}/close', 'JobController@close');
    Route::get('/job/{id}/edit', 'JobController@edit');
    Route::post('/job/{id}', 'JobController@update');
    Route::post('/job/{id}/inquire', 'InquiryController@store');
    Route::get('/inquiry/{id}', 'InquiryController@show');

    Route::get('/jobs', function () {
        return redirect('/job');
    });
});

/**
 * Q&A
 */
Route::group(['middleware' => ['web']], function () {
    Route::get('/question', 'QuestionController@index');
    Route::get('/question/create', 'QuestionController@create');
    Route::post('/question', 'QuestionController@store');
    Route::get('/question/{id}', 'QuestionController@show');
    Route::get('/question/{id}/approve', 'QuestionController@approve');
    Route::get('/question/{id}/disapprove', 'QuestionController@disapprove');
    Route::get('/question/{id}/edit', 'QuestionController@edit');
    Route::post('/question/{id}', 'QuestionController@update');
    Route::post('/question/{id}/answer', 'AnswerController@store');
    Route::get('/answer/{id}/approve', 'AnswerController@approve');
    Route::get('/answer/{id}/disapprove', 'AnswerController@disapprove');
    Route::get('/answer/{id}/edit', 'AnswerController@edit');
    Route::post('/answer/{id}', 'AnswerController@update');

    Route::get('/questions', function () {
        return redirect('/question');
    });
});

/**
 * Admin
 */
Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/admin', 'IndexController@index');
    Route::get('/admin/question', 'QuestionController@index');
    Route::get('/admin/job', 'JobController@index');
    Route::get('/admin/user', 'UserController@index');
});

/**
 * Social media
 */
Route::get('/social/instagram', 'SocialMediaController@instagram');
