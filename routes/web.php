<?php

/**
 * Static
 */

Route::get('/', function () {
    return view('home');
});
Route::get('about', function () {
    return view('about');
});
Route::get('contact', function () {
    return view('contact');
});
Route::get('register', function () {
    return view('register');
});
Route::get('services', function () {
    return view('services');
});
Route::get('blog', function () {
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
 * User
 */

Route::group(['namespace' => 'User'], function () {
    // namespace App\Http\Controllers\User
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

Route::group(['namespace' => 'Admin'], function () {
    // namespace App\Http\Controllers\Admin
});
