<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Admin
        Gate::define('view-admin-dashboard', function ($user) {
            return $user->hasAccess('admin_index');
        });
        Gate::define('view-admin-users', function ($user) {
            return $user->hasAccess('admin_user');
        });
        Gate::define('view-admin-questions', function ($user) {
            return $user->hasAccess('admin_question');
        });
        Gate::define('view-admin-jobs', function ($user) {
            return $user->hasAccess('admin_job');
        });

        // User
        Gate::define('view-user', function ($auth_user, $user) {
            return $auth_user->id == $user->id || $auth_user->hasAccess('user_show');
        });
        Gate::define('edit-user', function ($auth_user, $user) {
            return $auth_user->id == $user->id || $auth_user->hasAccess('user_edit');
        });
        Gate::define('view-profile', function ($auth_user, $user) {
            return $auth_user->id == $user->id || $auth_user->hasAccess('profile_show');
        });
        Gate::define('edit-profile', function ($auth_user, $user) {
            return $auth_user->id == $user->id || $auth_user->hasAccess('profile_edit');
        });

        // Q&A
        Gate::define('view-question-index', function ($user) {
            return $user->hasAccess('question_index');
        });
        Gate::define('view-question', function ($user) {
            return $user->hasAccess('question_show');
        });
        Gate::define('create-question', function ($user) {
            return $user->hasAccess('question_create');
        });
        Gate::define('edit-question', function ($user, $question) {
            return $user->id == $question->user_id || $user->hasAccess('question_edit');
        });
        Gate::define('approve-question', function ($user) {
            return $user->hasAccess('question_approve');
        });
        Gate::define('create-answer', function ($user) {
            return $user->hasAccess('answer_create');
        });
        Gate::define('edit-answer', function ($user, $answer) {
            return $user->id == $answer->user_id || $user->hasAccess('answer_edit');
        });
        Gate::define('approve-answer', function ($user) {
            return $user->hasAccess('answer_approve');
        });

        // Job board
        Gate::define('view-job-board', function ($user) {
            return $user->hasAccess('job_index');
        });
        Gate::define('view-job', function ($user) {
            return $user->hasAccess('job_show');
        });
        Gate::define('create-job', function ($user) {
            return $user->hasAccess('job_create');
        });
        Gate::define('edit-job', function ($user, $job) {
            return $user->id == $job->user_id || $user->hasAccess('job_edit');
        });
        Gate::define('close-job', function ($user) {
            return $user->hasAccess('job_close');
        });
        Gate::define('create-inquiry', function ($user) {
            return $user->hasAccess('inquiry_create');
        });
        Gate::define('edit-inquiry', function ($user) {
            return $user->hasAccess('inquiry_edit');
        });

        // Blog
        // Gate::define('view-post', function ($user) {
        //     return $user->hasAccess('post_show');
        // });
        Gate::define('create-post', function ($user) {
            return $user->hasAccess('post_create');
        });
        Gate::define('edit-post', function ($user, $post) {
            return $user->id == $post->user_id || $user->hasAccess('post_edit');
        });

        // Tags
        Gate::define('create-tag', function ($user) {
            return $user->hasAccess('tag_create');
        });

        // Blog
        Gate::define('create-session', function ($user) {
            return $user->hasAccess('session_create');
        });
        Gate::define('edit-session', function ($user, $session) {
            return $user->id == $session->user_id || $user->hasAccess('session_edit');
        });

        // Notes
        Gate::define('view-profile-notes', function ($user) {
            return $user->hasAccess('profile_note_show');
        });
        Gate::define('create-profile-note', function ($user) {
            return $user->hasAccess('profile_note_create');
        });
        Gate::define('view-inquiry-notes', function ($user) {
            return $user->hasAccess('inquiry_note_show');
        });
        Gate::define('create-inquiry-note', function ($user) {
            return $user->hasAccess('inquiry_note_create');
        });
    }
}
