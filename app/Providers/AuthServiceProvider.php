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
        Gate::define('view-admin-leagues', function ($user) {
            return $user->hasAccess('admin_league');
        });
        Gate::define('view-admin-organizations', function ($user) {
            return $user->hasAccess('admin_organization');
        });
        Gate::define('view-admin-reports', function ($user) {
            return $user->hasAccess('reports_show');
        });
        Gate::define('view-admin-pipelines', function($user) {
            return $user->hasAccess('pipeline_show');
        });
        Gate::define('edit-roles', function ($user) {
            return $user->hasAccess('edit_roles');
        });
        Gate::define('delete-contacts', function ($user) {
            return $user->hasAccess('delete_contacts');
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
        Gate::define('link-accounts', function ($user) {
            return $user->hasAccess('account_link');
        });


        // Clubhouse member
        Gate::define('view-clubhouse', function ($auth_user) {
            return $auth_user->hasAccess('clubhouse_view');
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

        // Admin board
        Gate::define('view-job-board', function ($user) {
            return $user->hasAccess('job_index');
        });
        Gate::define('view-job', function ($user) {
            return $user->hasAccess('job_show');
        });
        Gate::define('edit-job-featured-status', function ($user) {
            return $user->hasAccess('job_edit');
        });
        Gate::define('edit-job-recruiting-type', function ($user) {
            return $user->hasAccess('job_edit');
        });
        Gate::define('edit-job-logo', function ($user) {
            return $user->hasAccess('job_edit');
        });
        Gate::define('edit-expired-jobs', function ($user) {
            return $user->hasAccess('job_edit_expired');
        });

        // User Job board
        Gate::define('create-premium-user-job', function ($user) {
            return $user->hasAccess('job_premium_user');
        });
        Gate::define('create-platinum-user-job', function ($user) {
            return $user->hasAccess('job_platinum_user');
        });
        Gate::define('close-user-job', function ($user, $job) {
            return $user->hasAccess('job_close') || $user->hasAccess('job_close_user');
        });
        Gate::define('create-job', function ($user) {
            return $user->hasAccess('job_create') || $user->hasAccess('job_create_user');
        });
        Gate::define('edit-job', function ($user, $job) {
            if ($user->hasAccess('job_edit')) {
                return true;
            }
            if ($user->hasAccess('job_edit_user') && $job->user_id == $user->id) {
                return true;
            }
            return false;
        });
        Gate::define('close-job', function ($user, $job) {
            if ($user->hasAccess('job_close')) {
                return true;
            }
            if ($user->hasAccess('job_close_user') && $job->user_id == $user->id) {
                return true;
            }
            return false;
        });
        Gate::define('review-inquiry', function ($user, $inquiry) {
            // TODO change to review
            //dd($user->hasAccess('inquiry_edit'));
            if ($user->hasAccess('inquiry_edit')) {
                return true;
            }
            if ($user->hasAccess('job_edit_user') && $inquiry->job->user_id == $user->id) {
                return true;
            }
            return false;
        });
        Gate::define('review-inquiry-admin', function ($user) {
            // TODO change to review
            if ($user->hasAccess('inquiry_edit')) {
                return true;
            }
            return false;
        });

        // Generic Job board
        Gate::define('create-inquiry', function ($user) {
            return $user->hasAccess('inquiry_create');
        });
        Gate::define('edit-inquiry', function ($user) {
            return $user->hasAccess('inquiry_edit');
        });

        // Leagues
        Gate::define('view-league', function ($user) {
            return $user->hasAccess('league_show');
        });
        Gate::define('create-league', function ($user) {
            return $user->hasAccess('league_create');
        });
        Gate::define('edit-league', function ($user) {
            return $user->hasAccess('league_edit');
        });

        // Organizations
        Gate::define('view-organization', function ($user) {
            return $user->hasAccess('organization_show');
        });
        Gate::define('create-organization', function ($user) {
            return $user->hasAccess('organization_create');
        });
        Gate::define('edit-organization', function ($user, $organization) {
            if ($user->hasAccess('organization_edit')) {
                return true;
            }
            if ($user->hasAccess('organization_edit_user') && $organization->user_id == $user->id) {
                return true;
            }
            return false;
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
        Gate::define('delete-post', function ($user) {
            return $user->hasAccess('post_delete');
        });

        // Tags
        Gate::define('create-tag', function ($user) {
            return $user->hasAccess('tag_create');
        });
        Gate::define('create-tag-type', function ($user) {
            return $user->hasAccess('tag_type_create');
        });
        Gate::define('delete-tag-type', function ($user) {
            return $user->hasAccess('tag_type_delete');
        });

        // Archive sessions (session post type)
        Gate::define('create-post-session', function ($user) {
            return $user->hasAccess('post_session_create');
        });
        Gate::define('edit-post-session', function ($user, $post) {
            return $user->id == $post->user_id || $user->hasAccess('post_session_edit');
        });

        // Notes
        Gate::define('view-contact-notes', function ($user) {
            return $user->hasAccess('contact_note_show');
        });
        Gate::define('create-contact-note', function ($user, $contact_job = null) {
            if ($user->hasAccess('contact_note_create')) {
                return true;
            }
            if ($user->hasAccess('job_edit_user') && !is_null($contact_job) && $contact_job->job->user_id == $user->id) {
                return true;
            }
            return false;
        });
        Gate::define('view-inquiry-notes', function ($user) {
            return $user->hasAccess('inquiry_note_show');
        });
        Gate::define('create-inquiry-note', function ($user, $inquiry) {
            if ($user->hasAccess('inquiry_note_create')) {
                return true;
            }
            if ($user->hasAccess('job_edit_user') && $inquiry->job->user_id == $user->id) {
                return true;
            }
            return false;
        });
        Gate::define('delete-note', function ($user) {
            return $user->hasAccess('note_delete');
        });

        // Contact
        Gate::define('create-contact', function ($user) {
            return $user->hasAccess('contact_create');
        });
        Gate::define('edit-contact', function ($user) {
            return $user->hasAccess('contact_edit');
        });
        Gate::define('view-contact', function ($user) {
            return $user->hasAccess('contact_show');
        });
        Gate::define('add-contact-relationship', function ($user) {
            return $user->hasAccess('contact_relationship_create');
        });
        Gate::define('remove-contact-relationship', function ($user) {
            return $user->hasAccess('contact_relationship_delete');
        });
        Gate::define('follow-up', function ($user) {
            return $user->hasAccess('follow_up');
        });

        Gate::define('review-contact-job', function ($user, $contact_job) {
            // TODO change to review
            if ($user->hasAccess('contact_edit')) {
                return true;
            }
            if ($user->hasAccess('job_edit_user') && $contact_job->job->user_id == $user->id) {
                return true;
            }
            return false;
        });

        // Images
        Gate::define('admin-image', function ($user) {
            return $user->hasAccess('image_admin');
        });

        // Emails
        Gate::define('edit-email', function ($user) {
            return $user->hasAccess('email_edit');
        });

        // Mentor
        Gate::define('view-mentor', function ($auth_user) {
            return $auth_user->hasAccess('mentor_show');
        });
        Gate::define('edit-mentor', function ($auth_user) {
            return $auth_user->hasAccess('mentor_edit');
        });
        Gate::define('create-mentor', function ($auth_user) {
            return $auth_user->hasAccess('mentor_create');
        });

        // Product
        Gate::define('admin-product', function ($auth_user) {
            return $auth_user->hasAccess('product_admin');
        });
        Gate::define('view-product', function ($auth_user) {
            return $auth_user->hasAccess('product_show');
        });
        Gate::define('edit-product', function ($auth_user) {
            return $auth_user->hasAccess('product_edit');
        });
        Gate::define('create-product', function ($auth_user) {
            return $auth_user->hasAccess('product_create');
        });
    }
}
