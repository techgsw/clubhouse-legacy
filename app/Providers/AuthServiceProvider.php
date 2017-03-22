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

        Gate::define('create-question', function ($user) {
            return $user->hasAccess('question_create');
        });
        Gate::define('edit-question', function ($user, $question) {
            return $user->id == $question->user_id || $user->hasAccess('question_edit');
        });
        Gate::define('approve-question', function ($user, $question) {
            return $user->hasAccess('question_approve');
        });
    }
}
