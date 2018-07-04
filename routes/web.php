<?php

use App\Post;

// Static
Route::get('/', function () {
    return view('index');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/bob-hamer', function () {
    return view('bob-hamer');
});
Route::get('/jason-stein', function () {
    return view('jason-stein');
});
Route::get('/josh-belkoff', function () {
    return view('josh-belkoff');
});
Route::get('/mike-rudner', function () {
    return view('mike-rudner');
});
Route::get('/adam-vogel', function () {
    return view('adam-vogel');
});
Route::get('/blog', function () {
    return redirect('https://blog.sportsbusiness.solutions/');
});
Route::get('/career-services', function () {
    return view('career-services');
});
Route::get('/gallery', function () {
    return view('gallery');
});
Route::get('/gallery-2', function () {
    return redirect('gallery');
});
Route::get('/network', function () {
    return view('network');
});
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});
Route::get('/recruiting-3', function () {
    return redirect('recruiting');
});
Route::get('/recruiting', function () {
    return view('recruiting');
});
Route::get('/refund-policy-2', function () {
    return redirect('refund-policy');
});
Route::get('/refund-policy', function () {
    return view('refund-policy');
});
Route::get('/services', function () {
    return view('services');
});
Route::get('/sports-business-solutions-career-success-stories', function () {
    return redirect('success-stories');
});
Route::get('/success-stories', function () {
    return view('success-stories');
});
Route::get('/terms-of-service', function () {
    return view('terms-of-service');
});
Route::get('/training-consulting', function () {
    return view('training-consulting');
});
Route::get('/video', function () {
    return redirect('videos');
});
Route::get('/videos', function () {
    return view('videos');
});

// Contact
Route::get('/contact', 'ContactUsController@index');
Route::post('/contact', 'ContactUsController@send');
Route::get('/contact/thanks', 'ContactUsController@thanks');

// Auth
Route::group(['namespace' => 'Auth'], function () {
    Route::get('login', 'LoginController@login')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('/auth/login/header', 'LoginController@header');
});
Auth::routes();

// Archives
Route::group(['middleware' => ['web']], function () {
    Route::get('/archives', 'ArchivesController@index');
    Route::get('/session', function () {
        return redirect('/archives');
    });
    Route::get('/session/create', 'SessionController@create');
    Route::get('/session', 'SessionController@index');
    Route::post('/session', 'SessionController@store');
    Route::get('/session/{id}', 'SessionController@show');
    Route::get('/session/{id}/edit', 'SessionController@edit');
    Route::get('/session/{id}/delete-image/{image_id}', 'SessionController@deleteImage');
    Route::post('/session/{id}', 'SessionController@update');
    Route::post('/session/{id}/image', 'SessionController@addImage');
    Route::post('/session/{id}/image-order', 'SessionController@imageOrder');
});

// Blog
Route::group(['middleware' => ['web']], function () {
    Route::get('/blog', 'BlogController@index');
    Route::get('/blog/{id}', 'BlogController@show');
    Route::get('/post', function () {
        return redirect('/blog');
    });
    Route::get('/post/create', 'PostController@create');
    Route::post('/post', 'PostController@store');
    Route::get('/post/{id}', 'PostController@show');
    Route::get('/post/{id}/edit', 'PostController@edit');
    Route::post('/post/{id}', 'PostController@update');

    // Dynamic routes for post slugs
    Post::each(function ($post) {
        Route::get('/'.$post->title_url, function() {
            return redirect('/post/'.$this->current->uri);
        });
    });

    Route::post('/tag', 'TagController@store');
    Route::get('/tag/all', 'TagController@all');
});

// User
Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/user/{id}', 'UserController@show');
    Route::get('/user/{id}/jobs', 'UserController@jobs');
    Route::get('/user/{id}/questions', 'UserController@questions');

    Route::get('/user/{id}/profile', 'ProfileController@show');
    Route::get('/user/{id}/edit-profile', 'ProfileController@edit');
    Route::post('/user/{id}/profile', 'ProfileController@update');
    Route::get('/user/{id}/show-notes', 'ProfileController@showNotes');
    Route::post('/user/{id}/create-note', 'ProfileController@createNote');
});

// Contact
Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/contact/create', 'ContactController@create');
    Route::post('/contact', 'ContactController@store');
    Route::post('/contact/add-relationship', 'ContactController@addRelationship');
    Route::post('/contact/remove-relationship', 'ContactController@removeRelationship');
    Route::post('/contact/{id}/schedule-follow-up', 'ContactController@scheduleFollowUp');
    Route::post('/contact/{id}/reschedule-follow-up', 'ContactController@rescheduleFollowUp');
    Route::post('/contact/{id}/close-follow-up', 'ContactController@closeFollowUp');
    Route::get('/contact/{id}', 'ContactController@show');
    Route::post('/contact/{id}', 'ContactController@update');
    Route::get('/contact/{id}/show-note-control', 'ContactController@showNoteControl');
    Route::post('/contact/{id}/create-note', 'ContactController@createNote');
});

// Mentor
Route::group(['middleware' => ['web','auth']], function () {
    Route::get('/mentor', 'MentorController@index');
    Route::get('/mentor/{id}', 'MentorController@show');
    Route::get('/contact/{id}/mentor', 'MentorController@edit');
    Route::post('/mentor/{id}', 'MentorController@update');
});

// Notes
Route::group(['middleware' => ['web','auth']], function () {
    Route::post('/note/{id}/delete', 'NoteController@delete');
});

// Jobs
Route::group(['middleware' => ['web']], function () {
    Route::get('/job', 'JobController@index');
    Route::get('/job/create', 'JobController@create');
    Route::post('/job', 'JobController@store');
    Route::get('/job/{id}', 'JobController@show');
    Route::get('/job/{id}/open', 'JobController@open');
    Route::get('/job/{id}/close', 'JobController@close');
    Route::get('/job/{id}/feature', 'JobController@feature');
    Route::get('/job/{id}/unfeature', 'JobController@unfeature');
    Route::get('/job/{id}/rank-up', 'JobController@rankUp');
    Route::get('/job/{id}/rank-top', 'JobController@rankTop');
    Route::get('/job/{id}/rank-down', 'JobController@rankDown');
    Route::get('/job/{id}/edit', 'JobController@edit');
    Route::post('/job/{id}', 'JobController@update');
    Route::post('/job/{id}/inquire', 'InquiryController@store');

    Route::get('/inquiry/{id}/rate-up', 'InquiryController@rateUp');
    Route::get('/inquiry/{id}/rate-maybe', 'InquiryController@rateMaybe');
    Route::get('/inquiry/{id}/rate-down', 'InquiryController@rateDown');
    Route::get('/inquiry/{id}/show-notes', 'InquiryController@showNotes');
    Route::post('/inquiry/{id}/create-note', 'InquiryController@createNote');

    Route::get('/jobs', function () {
        return redirect('/job');
    });
});

// Organizations
Route::group(['middleware' => ['web']], function () {
    Route::get('/admin/organization', 'OrganizationController@index');
    Route::get('/organization/create', 'OrganizationController@create');
    Route::post('/organization', 'OrganizationController@store');
    Route::get('/organization/all', 'OrganizationController@all');
    Route::get('/organization/leagues', 'OrganizationController@leagues');
    Route::get('/organization/{id}', 'OrganizationController@show');
    Route::get('/organization/{id}/edit', 'OrganizationController@edit');
    Route::get('/organization/{id}/preview', 'OrganizationController@preview');
    Route::post('/organization/{id}', 'OrganizationController@update');
    Route::get('/organization/{id}/match-contacts', 'OrganizationController@matchContacts');
});

// Q&A
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

// Images
Route::group(['middleware' => ['web']], function () {
    Route::get('/admin/image', 'ImageController@index');
    Route::get('/image/{id}', 'ImageController@show');
});

// Email
Route::group(['middleware' => ['web']], function () {
    Route::get('/email', 'EmailController@index');
    Route::post('/email/update', 'EmailController@update');
});

// Admin
Route::group(['namespace' => 'Admin', 'middleware' => ['web','auth']], function () {
    Route::get('/admin', 'IndexController@index');
    Route::get('/admin/contact', 'ContactController@index');
    Route::get('/admin/contact/download', 'ContactController@download');
    Route::get('/admin/job', 'JobController@index');
    Route::get('/admin/question', 'QuestionController@index');
    Route::get('/admin/admin-users', 'UserController@allAdminUsers');
    Route::get('/admin/report', 'ReportController@index');
    Route::get('/admin/follow-up', 'FollowUpController@index');
});

// Social Media
Route::get('/social/instagram', 'SocialMediaController@instagram');
