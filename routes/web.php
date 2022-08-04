<?php

use App\Post;

// All-domain routes

// Social Media
Route::get('/social/instagram', 'SocialMediaController@instagram');
Route::get('/social/twitter', 'SocialMediaController@twitter');

// SBS-domain routes
Route::domain(env('APP_URL'))->group(function () {
    // Static
    Route::get('/', function () {
        return view('index');
    });
    Route::get('/about', function () {
        return view('about');
    });
    Route::get('/clients', function () {
        return view('clients');
    });
    Route::get('/bob-hamer', function () {
        return view('bob-hamer');
    });
    Route::get('/jason-stein', function () {
        return view('jason-stein');
    });
    Route::get('/mike-rudner', function () {
        return view('mike-rudner');
    });
    Route::get('/blog', function () {
        return redirect('https://blog.sportsbusiness.solutions/');
    });
    Route::get('/gallery', function () {
        return view('gallery');
    });
    Route::get('/gallery-2', function () {
        return redirect('/gallery');
    });
    Route::get('/network', function () {
        return view('network');
    });
    Route::get('/privacy-policy', function () {
        return view('privacy-policy');
    });
    Route::get('/refund-policy-2', function () {
        return redirect('/refund-policy');
    });
    Route::get('/refund-policy', function () {
        return view('refund-policy');
    });
    Route::get('/sports-business-solutions-career-success-stories', function () {
        return redirect('/success-stories');
    });
    Route::get('/success-stories', function () {
        return view('success-stories');
    });
    Route::get('/terms-of-service', function () {
        return view('terms-of-service');
    });
    Route::get('/video', function () {
        return redirect('/videos');
    });
    Route::get('/videos', function () {
        return view('videos');
    });
    Route::get('/recruiting-3', function () {
        return redirect('/recruiting');
    });
    Route::get('/recruiting', function () {
        return view('recruiting');
    });
    Route::get('/services', function () {
        return view('services');
    });
    Route::get('/training-consulting', function () {
        return view('training-consulting');
    });

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

    // Contact
    Route::group(['middleware' => ['web']], function () {
        Route::get('/contact', 'ContactUsController@index');
        Route::post('/contact', 'ContactUsController@send');
        Route::get('/contact/thanks', 'ContactUsController@thanks');
    });

});

// Clubhouse-domain routes
Route::domain(env('CLUBHOUSE_URL'))->group(function () {
    // Auth
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('login', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::get('/auth/login/header', 'LoginController@header');

        Route::get('register/{id}', 'RegisterController@registerInfluencer');
        Route::get('register/pro', 'RegisterController@pro');
        Route::post('/register/is-this-you/{type}', 'RegisterController@registerIsThisYou');
    });
    Auth::routes();

    // Admin
    Route::group(['namespace' => 'Admin', 'middleware' => ['web','auth']], function () {
        Route::get('/admin', 'IndexController@index');
        Route::get('/admin/contact', 'ContactController@index');
        Route::get('/admin/contact/{id}/delete', 'ContactController@delete');
        Route::get('/admin/contact/download', 'ContactController@download');
        Route::get('/admin/job', 'JobController@index');
        Route::get('/admin/job/disciplines', 'JobController@editDisciplines');

        //refactoring jobs to be in admin domain since we will be restricting job admins
        Route::get('/job/register', 'JobController@register');
        Route::get('/job/create', 'JobController@create');
        Route::post('/job/create', 'JobController@store');
        Route::get('/job/{id}/feature', 'JobController@feature');
        Route::get('/job/{id}/unfeature', 'JobController@unfeature');
        Route::get('/job/{id}/rank-up', 'JobController@rankUp');
        Route::get('/job/{id}/rank-top', 'JobController@rankTop');
        Route::get('/job/{id}/rank-down', 'JobController@rankDown');
        Route::get('/job/{id}/make-admin', 'JobController@convertToAdminJob');

        Route::get('/admin/pipeline', 'PipelineController@index');

        Route::post('/admin/user/link-accounts', 'UserController@linkAccounts');
        Route::get('/admin/user/unlink-account/{id}', 'UserController@unlinkAccount');

        Route::get('/admin/question', 'QuestionController@index');
        Route::get('/admin/admin-users', 'UserController@allAdminUsers');
        Route::get('/admin/report', 'ReportController@index');
        Route::get('/admin/report/notes', 'ReportController@notes');
        Route::get('/admin/report/transactions', 'ReportController@transactions');
        Route::get('/admin/report/clubhouse', 'ReportController@clubhouseMembers');
        Route::get('/admin/report/clubhouse/download', 'ReportController@downloadClubhouseMembers');
        Route::get('/admin/report/ajax-product-type-purchase-report', 'ReportController@ajaxProductTypePurchaseCountGraph');
        Route::get('/admin/follow-up', 'FollowUpController@index');
        Route::get('/admin/influencers', 'InfluencersController@index');
        //endpoint for editing the user roles
        Route::get('/admin/{id}/edit-roles', 'RoleController@index');
        Route::post('/admin/{id}/update-roles', 'RoleController@update');
    });

    // Admin & Ajax
    Route::group(['namespace' => 'Admin', 'middleware' => ['web','auth', 'ajax_only']], function () {
        Route::post('/admin/inquiry/pipeline-backward', 'InquiryController@pipelineBackward');
        Route::post('/admin/inquiry/pipeline-pause', 'InquiryController@pipelinePause');

        Route::post('/admin/contact-job/pipeline-backward/', 'ContactJobController@pipelineBackward');
        Route::post('/admin/contact-job/pipeline-pause/', 'ContactJobController@pipelinePause');
    });

    Route::group(['namespace' => 'Admin', 'middleware' => ['web', 'ajax_only']], function () {
        Route::post('/admin/inquiry/pipeline-forward', 'InquiryController@pipelineForward');
        Route::post('/admin/inquiry/pipeline-halt', 'InquiryController@pipelineHalt');

        Route::post('/admin/contact-job/pipeline-forward/', 'ContactJobController@pipelineForward');
        Route::post('/admin/contact-job/pipeline-halt/', 'ContactJobController@pipelineHalt');

        Route::get('/admin/user/show-link-account-suggestions', 'UserController@showLinkAccountSuggestions');
    });

    // Email
    Route::group(['middleware' => ['web']], function () {
        Route::get('/email', 'EmailController@index');
        Route::post('/email/update', 'EmailController@update');
    });

    // Archives
    Route::group(['middleware' => ['web']], function () {
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
        Route::get('/post/create', 'PostController@create');
        Route::post('/post', 'PostController@store');
        Route::get('/post/{id}/edit', 'PostController@edit');
        Route::post('/post/{id}', 'PostController@update');
        Route::get('/post/{id}/delete', 'PostController@destroy');


        //TODO move this out of blog
        Route::post('/tag', 'TagController@store');
        Route::get('/tag/all', 'TagController@all');
        Route::get('/tag/posts', 'TagController@posts');
        Route::get('/tag/mentors', 'TagController@mentors');
        Route::get('/tag/jobs', 'TagController@jobs');
        Route::get('/tag/delete-from-type', 'TagController@deleteFromType');
        Route::post('/tag/add-to-type', 'TagController@addToType');
    });

    // Blog
    Route::group(['middleware' => ['web']], function () {
        Route::get('/blog', 'BlogController@index');
        Route::get('/blog/{id}', 'BlogController@show');
        Route::get('/post', function () {
            return redirect('/blog');
        });
        Route::get('/post/{id}', 'PostController@show');

        // Dynamic routes for post slugs
        Post::each(function ($post) {
            Route::get('/'.$post->title_url, function() {
                return redirect('/post/'.$this->current->uri);
            });
        });
    });

    // Career services
    Route::group(['middleware' => ['web']], function () {
        Route::get('/career-services', 'ProductController@careerServices');
        Route::get('/career-services/{id}', 'ProductController@showCareerServices');
        Route::get('/career-services/{id}/schedule', 'ProductController@scheduleCareerService');
    });

    // Checkout
    Route::group(['middleware' => ['web','auth']], function () {
        Route::post('/checkout/add-card', 'CheckoutController@addCard');
        Route::post('/checkout/make-card-primary', 'CheckoutController@makeCardPrimary');
        Route::post('/checkout/remove-card', 'CheckoutController@removeCard');
        Route::post('/checkout/cancel-subscription', 'CheckoutController@cancelSubscription');
        Route::post('/checkout/reactivate-subscription', 'CheckoutController@reactivateSubscription');
        Route::post('/checkout', 'CheckoutController@store');
        Route::get('/checkout/thanks', 'CheckoutController@thanks');
        Route::get('/checkout/{id}', 'CheckoutController@index');
        Route::get('/checkout/{id}/{job_id}', 'CheckoutController@index');
    });

    // Clubhouse
    Route::group(['middleware' => ['web']], function () {
        Route::get('/', 'ClubhouseController@index');
    });

    // Contacts
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
        Route::get('/contact/{id}/jobs', 'ContactController@jobs');
        Route::get('/contact/{id}/show-note-control', 'ContactController@showNoteControl');
        Route::post('/contact/{id}/create-note', 'ContactController@createNote');
    });


    // Images
    Route::group(['middleware' => ['web']], function () {
        Route::get('/admin/image', 'ImageController@index');
        Route::get('/image/{id}', 'ImageController@show');
    });

    // Jobs
    Route::group(['middleware' => ['web', 'ajax_only', 'auth']], function () {
        Route::get('/job/assign-contact', 'JobController@assignContact');
        Route::post('/contact-job', 'ContactJobController@store');
        Route::post('/contact-job/delete', 'ContactJobController@delete');
    });

    Route::group(['middleware' => ['web']], function () {
        Route::get('job/register', 'JobController@register');
        Route::get('/job/create', 'JobController@create');
        Route::post('/job/create', 'JobController@store');
        // Route::post('/job', 'JobController@store');
        Route::get('/job/{id}/open', 'JobController@open');
        Route::get('/job/{id}/close', 'JobController@close');
        Route::get('/job/{id}/edit', 'JobController@edit');
        Route::post('/job/{id}', 'JobController@update');
        Route::post('/job/{id}/inquire', 'InquiryController@store');

        Route::get('/contact-job/{id}/rate-down', 'ContactJobController@rateDown');
        Route::get('/contact-job/{id}/show-notes', 'ContactJobController@showNotes');
        Route::post('/contact-job/{id}/create-note', 'ContactJobController@createNote');
        Route::get('/contact/feedback/{id}', 'ContactJobController@feedback');
        Route::post('/contact/feedback/{id}', 'ContactJobController@feedbackNegativeReason');
        Route::get('/user-assigned/feedback/{id}', 'ContactJobController@feedback');
        Route::post('/user-assigned/feedback/{id}', 'ContactJobController@feedbackNegativeReason');

        Route::get('/inquiry/{id}/rate-down', 'InquiryController@rateDown');
        Route::get('/inquiry/{id}/show-notes', 'InquiryController@showNotes');
        Route::post('/inquiry/{id}/create-note', 'InquiryController@createNote');

        Route::get('/job', 'JobController@index');
        Route::get('/job/{id}', 'JobController@show');
        Route::get('/jobs', function () {
            return redirect('/job');
        });
    });

    // Mentor
    Route::group(['middleware' => ['web']], function () {
        Route::get('/mentor', 'MentorController@index');
        Route::get('/mentor/{id}', 'MentorController@show');
    });
    Route::group(['middleware' => ['web','auth']], function () {
        Route::post('/mentor/{id}/request', 'MentorController@request');
        Route::get('/mentor/{id}/request', 'MentorController@request');
        Route::post('/mentor/{id}', 'MentorController@update');
        Route::get('/contact/{id}/mentor', 'MentorController@edit');
    });

    // Notes
    Route::group(['middleware' => ['web','auth']], function () {
        Route::post('/note/{id}/delete', 'NoteController@delete');
    });

    // Organizations
    Route::group(['middleware' => ['web', 'ajax_only']], function () {
        Route::get('/organization/{id}/preview', 'OrganizationController@preview');
    });

    Route::group(['middleware' => ['web']], function () {
        Route::get('/admin/organization', 'OrganizationController@index');
        Route::get('/organization/create', 'OrganizationController@create');
        Route::get('/organization', function () {
            return redirect('/admin/organization');
        });
        Route::post('/organization', 'OrganizationController@store');
        Route::get('/organization/all', 'OrganizationController@all');
        Route::get('/organization/leagues', 'OrganizationController@leagues');
        Route::get('/organization/{id}', 'OrganizationController@show');
        Route::get('/organization/{id}/edit', 'OrganizationController@edit');
        Route::post('/organization/{id}', 'OrganizationController@update');
        Route::get('/organization/{id}/match-contacts', 'OrganizationController@matchContacts');
    });


    // Pricing
    Route::group(['middleware' => ['web']], function () {
        Route::get('/job-options', 'ClubhouseController@jobOptions');
        Route::get('/job-options/{option_type}', 'ClubhouseController@jobOptions');
    });
    Route::group(['middleware' => ['web', 'redirect_router']], function() {
        Route::get('/pro-membership', 'ClubhouseController@proMembership');
        Route::post('/pro-membership', 'ClubhouseController@applyForProMembership');
        Route::get('/membership-options', 'ClubhouseController@proMembership');
    });

    // Resources
    Route::group(['middleware' => ['web']], function () {
        Route::get('/resources', 'ClubhouseController@resources');
    });

    // Product
    Route::group(['middleware' => ['web']], function () {
        Route::get('/product/admin', 'ProductController@admin');
        Route::get('/product/create', 'ProductController@create');
        Route::post('/product', 'ProductController@store');
        Route::get('/product/{id}/edit', 'ProductController@edit');
        Route::post('/product/{id}', 'ProductController@update');
        Route::get('/product/{id}', 'ProductController@show');
    });

    // User
    Route::group(['middleware' => ['web','auth']], function () {
        Route::get('/user/{id?}', 'UserController@show');
        Route::get('/user/{id?}/account', 'UserController@account');
        Route::get('/user/{id?}/jobs', 'UserController@jobs');
        Route::get('/user/{id?}/questions', 'UserController@questions');
        Route::get('/user/{id?}/job-postings', 'JobController@showPostings');


        Route::get('/user/{id?}/profile', 'ProfileController@show');
        Route::get('/user/{id?}/edit-profile', 'ProfileController@edit');
        Route::post('/user/{id}/profile', 'ProfileController@update');
        Route::get('/user/{id}/show-notes', 'ProfileController@showNotes');
        Route::post('/user/{id}/create-note', 'ProfileController@createNote');

    });

    // Unsubscribe
    Route::group(['middleware' => ['web']], function () {
        Route::get('/unsubscribe/{token}', 'ProfileController@showUnsubscribeOptions');
        Route::post('/unsubscribe/{token}', 'ProfileController@unsubscribe');
    });

    // Webinars
    Route::group(['middleware' => ['web']], function () {
        Route::get('/webinars', 'ProductController@webinars');
        Route::get('/webinars/{id}', 'ProductController@showWebinars');
    });

    // #SameHere
    Route::group(['middleware' => ['web']], function () {
        Route::get('/same-here', 'SameHereController@index');
        Route::get('/same-here/webinars', 'SameHereController@webinars');
        Route::get('/same-here/webinars/{id}', 'SameHereController@showWebinars');
        Route::get('/same-here/blog', 'SameHereController@blog');

        // Routes for discussion board
        Route::get('/same-here/discussion', 'QuestionController@index');
        Route::get('/same-here/discussion/create', 'QuestionController@create');
        Route::post('/same-here/discussion', 'QuestionController@store');
        Route::get('/same-here/discussion/{id}', 'QuestionController@show');
        Route::get('/same-here/discussion/{id}/approve', 'QuestionController@approve');
        Route::get('/same-here/discussion/{id}/disapprove', 'QuestionController@disapprove');
        Route::get('/same-here/discussion/{id}/edit', 'QuestionController@edit');
        Route::post('/same-here/discussion/{id}', 'QuestionController@update');
        Route::post('/same-here/discussion/{id}/answer', 'AnswerController@store');
        Route::get('/same-here/discussion/answer/{id}/approve', 'AnswerController@approve');
        Route::get('/same-here/discussion/answer/{id}/disapprove', 'AnswerController@disapprove');
        Route::get('/same-here/discussion/answer/{id}/edit', 'AnswerController@edit');
        Route::post('/same-here/discussion/answer/{id}/edit', 'AnswerController@update');
    });

    // Sales Vault now Training
    Route::group(['middleware' => ['web']], function () {
        Route::get('/sales-vault', 'ClubhouseController@salesVault');
        Route::get('/training', 'ClubhouseController@salesVault');

        Route::get('/sales-vault/training-videos', 'ProductController@trainingVideos');
        Route::get('/sales-vault/training-videos/all-tags', 'ProductController@getTrainingVideoTagsForAutocomplete');
        Route::get('/sales-vault/training-videos/{id}', 'ProductController@showTrainingVideo');

        Route::get('/training/training-videos', 'ProductController@trainingVideos');
        Route::get('/training/training-videos/all-tags', 'ProductController@getTrainingVideoTagsForAutocomplete');
        Route::get('/training/training-videos/{id}', 'ProductController@showTrainingVideo');

        // Routes for discussion board
        Route::get('/sales-vault/discussion', 'QuestionController@index');
        Route::get('/sales-vault/discussion/create', 'QuestionController@create');
        Route::post('/sales-vault/discussion', 'QuestionController@store');
        Route::get('/sales-vault/discussion/{id}', 'QuestionController@show');
        Route::get('/sales-vault/discussion/{id}/approve', 'QuestionController@approve');
        Route::get('/sales-vault/discussion/{id}/disapprove', 'QuestionController@disapprove');
        Route::get('/sales-vault/discussion/{id}/edit', 'QuestionController@edit');
        Route::post('/sales-vault/discussion/{id}', 'QuestionController@update');
        Route::post('/sales-vault/discussion/{id}/answer', 'AnswerController@store');
        Route::get('/sales-vault/discussion/answer/{id}/approve', 'AnswerController@approve');
        Route::get('/sales-vault/discussion/answer/{id}/disapprove', 'AnswerController@disapprove');
        Route::get('/sales-vault/discussion/answer/{id}/edit', 'AnswerController@edit');
        Route::post('/sales-vault/discussion/answer/{id}/edit', 'AnswerController@update');

    });
});
