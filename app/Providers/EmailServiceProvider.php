<?php

namespace App\Providers;

use App\Mail\ClubhouseFailedPaymentNotice;
use App\Mail\JobExpirationReminder;
use App\Mail\JobNoActionReminder;
use App\Post;
use App\Product;
use Mail;
use App\ContactJob;
use App\Email;
use App\Inquiry;
use App\Job;
use App\Mentor;
use App\Organization;
use App\User;
use App\ProductOption;
use App\Mail\ClubhouseFollowUp;
use App\Mail\ContactJobFollowup;
use App\Mail\InvalidMentorCalendlyLinkNotification;
use App\Mail\PurchaseNotification;
use App\Mail\MenteeFollowUp;
use App\Mail\MentorFollowUp;
use App\Mail\FreeUserFollowUp;
use App\Mail\UserPostJobFollowUp;
use App\Mail\UserRegistered;
use App\Mail\Admin\InquirySummary;
use App\Mail\Admin\InvalidMentorCalendlyLinkSummary;
use App\Mail\Admin\MonthlyMentorReport;
use App\Mail\Admin\RegistrationNotification;
use App\Mail\Admin\RegistrationSummary;
use App\Mail\Admin\UserJobPostNotification;
use App\Mail\Admin\UserOrganizationCreateNotification;
use App\Mail\MentorshipRequest;
use App\Mail\JobExpirationNotification;
use App\Mail\NewClubhouseContentEmail;
use App\Mail\NewJobTypeMatchPosted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class EmailServiceProvider extends ServiceProvider
{
    public static function sendMembershipPurchaseNotificationEmail(User $user, ProductOption $product_option, $amount, $type)
    {
        $admin_users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'memberships')
            ->select('user.*')
            ->get();

        Mail::to($admin_users)->send(new PurchaseNotification($user, $product_option, $amount, $type));
    }

    public static function sendWebinarPurchaseNotificationEmail(User $user, ProductOption $product_option, $amount, $type)
    {
        $admin_users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'webinars')
            ->select('user.*')
            ->get();

        Mail::to($admin_users)->send(new PurchaseNotification($user, $product_option, $amount, $type));
    }

    public static function sendCareerServicePurchaseNotificationEmail(User $user, ProductOption $product_option, $amount, $type)
    {
        $admin_users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'career_services')
            ->select('user.*')
            ->get();

        Mail::to($admin_users)->send(new PurchaseNotification($user, $product_option, $amount, $type));
    }

    public static function sendJobPremiumPurchaseNotificationEmail(User $user, ProductOption $product_option, $amount, $type)
    {
        $admin_users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'job_premium')
            ->select('user.*')
            ->get();

        Mail::to($admin_users)->send(new PurchaseNotification($user, $product_option, $amount, $type));
    }

    public static function sendJobPlatinumPurchaseNotificationEmail(User $user, ProductOption $product_option, $amount, $type)
    {
        $admin_users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'job_platinum')
            ->select('user.*')
            ->get();

        Mail::to($admin_users)->send(new PurchaseNotification($user, $product_option, $amount, $type));
    }

    public static function sendJobExtensionPurchaseNotificationEmail(User $user, ProductOption $product_option, $amount, $type)
    {
        $admin_users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'job_extension')
            ->select('user.*')
            ->get();

        Mail::to($admin_users)->send(new PurchaseNotification($user, $product_option, $amount, $type));
    }

    public static function sendUserJobPostNotificationEmail(User $user, Job $job)
    {
        Mail::to($user)->send(new UserPostJobFollowUp($user, $job));
        $users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'user_job_post')
            ->select('user.*')
            ->get();

        Mail::to($users)->send(new UserJobPostNotification($user));
    }

    public static function sendUserOrganizationCreateNotificationEmail(User $user, Organization $organization)
    {
        $users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'user_organization_create')
            ->select('user.*')
            ->get();

        Mail::to($users)->send(new UserOrganizationCreateNotification($user, $organization));
    }

    public static function sendRegistrationNotificationEmail(User $registrant)
    {
        $users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'registration_individual')
            ->select('user.*')
            ->get();

        Mail::to($users)->send(new RegistrationNotification($registrant));
    }

    public static function sendRegistrationSummaryEmail(\DateTime $start, \DateTime $end)
    {
        $users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'registration_summary')
            ->select('user.*')
            ->get();

        $registrants = User::whereBetween('created_at', [$start, $end]);

        Mail::to($users)->send(new RegistrationSummary($start, $end, $registrants));
    }

    public static function sendInquirySummaryEmail(\DateTime $start, \DateTime $end)
    {
        $users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'inquiry_summary')
            ->select('user.*')
            ->get();

        $inquiries = Inquiry::whereBetween('created_at', [$start, $end]);

        $jobs = Job::join('inquiry', 'inquiry.job_id', 'job.id')
            ->whereBetween('inquiry.created_at', [$start, $end])
            ->groupBy('job.id')
            ->select(DB::raw('job.*, COUNT(1) as inquiry_count'))
            ->having('inquiry_count', '>', 0)
            ->orderBy('inquiry_count', 'desc')
            ->get();

        Mail::to($users)->send(new InquirySummary($start, $end, $inquiries, $jobs));
    }

    public static function sendMentorshipRequestEmails(User $mentee, Mentor $mentor, array $dates)
    {
        // Alert admins about request
        $users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'mentorship_requests')
            ->select('user.*')
            ->get();

        if (empty($dates)) {
            Mail::to($users)->send(new \App\Mail\Admin\MentorshipRequest($mentor, $mentee, array()));
        } else {
            // Confirm request with user
            Mail::to($mentee)->send(new MentorshipRequest($mentor, $mentee, $dates));

            //TODO: Laravel's cc functionality is not working. They're being sent as two separate emails.
            // we need to investigate this at some point so this email can be sent to the mentor and
            // admins can be cc'd.
            Mail::to($mentor->contact->email, $mentor->contact->first_name.' '.$mentor->contact->last_name)
                ->cc($users)
                ->send(new \App\Mail\Admin\MentorshipRequest($mentor, $mentee, $dates));
        }
    }

    public static function sendJobExpirationNotificationEmail(Job $job) {
        $user = User::find($job->user_id);
        Mail::to($user)->send(new JobExpirationNotification($job, $user));
    }

    public static function sendJobExpirationReminderEmail(Job $job, int $number_of_days) {
        $user = User::find($job->user_id);
        Mail::to($user)->send(new JobExpirationReminder($job, $user, $number_of_days));
    }

    public static function sendJobNoActionReminderEmails()
    {
        $users = User::with(['postings' => function($postings_query) {
                $postings_query->where('job.job_status_id', '=', JOB_STATUS_ID['open']);
            },
            'postings.inquiries' => function($inquiries_query) {
                $inquiries_query->where('inquiry.pipeline_id', '=', 1);
            },
            'postings.assignments' => function($assignments_query) {
                $assignments_query->where('contact_job.pipeline_id', '=', 1);
            }])
            ->join('job', function ($join_job) {
                $join_job->on('user.id', '=', 'job.user_id')
                    ->where('job_status_id', '=', JOB_STATUS_ID['open']);
            })->leftJoin('inquiry', 'job.id', '=', 'inquiry.job_id')
            ->leftJoin('contact_job', 'job.id', '=', 'contact_job.job_id')
            ->where('inquiry.pipeline_id', '=', 1)
            ->orWhere('contact_job.pipeline_id', '=', 1)
            ->select('user.*')->distinct()->get();

        foreach ($users as $user) {
            Mail::to($user)->send(new JobNoActionReminder($user, $user->postings));
        }
    }

    public static function sendFailedClubhousePaymentNotice($date_since)
    {
        $failed_transactions = StripeServiceProvider::getFailedTransactionsSince($date_since);
        $clubhouse_product_stripe_id = Product::where('name', 'Clubhouse Pro Membership')->first()->stripe_product_id;
        foreach($failed_transactions->data as $transaction) {
            $clubhouse_product_found = false;
            foreach($transaction->data->object->lines->data as $purchase_item) {
                Log::info($purchase_item->plan->product);
                if ($purchase_item->plan->product == $clubhouse_product_stripe_id) {
                    $clubhouse_product_found = true;
                }
            }
            if ($clubhouse_product_found) {
                $user_to_notify = User::whereHas('roles', function ($query) {
                    $query->where('role_code', 'clubhouse');
                })->where('stripe_customer_id', $transaction->data->object->customer)->get();
                if (count($user_to_notify) > 0 && $transaction->data->object->attempt_count < 5) {
                    $next_attempt_date = new \DateTime();
                    $next_attempt_date->setTimestamp($transaction->data->object->next_payment_attempt);
                    Mail::to($user_to_notify->first())->send(new ClubhouseFailedPaymentNotice($user_to_notify->first(), $transaction->data->object->attempt_count, $next_attempt_date));
                }
            }
        }
    }

    public static function sendMentorshipFollowupEmails($date_since)
    {
        $days_since = (new \DateTime('now'))->diff($date_since)->format("%a");

        $mentors = Mentor::with([
            'contact',
            'mentorRequests' => function($query) use ($date_since) {
                $query->where('created_at', '>', $date_since);
            },
            'mentorRequests.mentee'
        ])->whereHas('mentorRequests', function($query) use ($date_since) {
            $query->where('created_at', '>', $date_since);
        })->get();

        foreach ($mentors as $mentor) {
            Mail::to($mentor->contact->email)->send(new MentorFollowup($mentor, $days_since));
        }

        $mentees = User::with([
            'mentorRequests' => function($query) use ($date_since) {
                $query->where('created_at', '>', $date_since);
            },
            'mentorRequests.mentor.contact'
        ])->whereHas('mentorRequests', function($query) use ($date_since) {
            $query->where('created_at', '>', $date_since);
        })->get();

        $total_requests = 0;

        foreach ($mentees as $mentee) {
            $total_requests += count($mentee->mentorRequests);
            Mail::to($mentee)->send(new MenteeFollowUp($mentee, $days_since));
        }

        $mentors = $mentors->sortByDesc(function ($mentor, $key) {
            return count($mentor->mentorRequests);
        });

        $mentees = $mentees->sortByDesc(function ($mentee, $key) {
            return count($mentee->mentorRequests);
        });

        Mail::to(__('email.info_address'))->send(new MonthlyMentorReport($mentors, $mentees, $total_requests, $days_since));
    }

    public static function sendInvalidMentorCalendlyLinkNotification($mentors)
    {
        foreach ($mentors as $mentor) {
            Mail::to($mentor->contact->email)->send(new InvalidMentorCalendlyLinkNotification($mentor));
        }

        Mail::to(__('email.info_address'))->send(new InvalidMentorCalendlyLinkSummary($mentors));
    }

    /**
     * Handle all drip campaign and reengagement emails. Should be run daily
     */
    public static function sendFollowUpEmails()
    {
        // Send all drip campaing follow up emails for free and pro users
        $clubhouse_subscription_users = User::select('user.*')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('role_code', 'administrator');
            })->whereHas('profile', function ($query) {
                $query->where('email_preference_marketing', true);
            })->join('transaction as t', 'user.id', 't.user_id')
            ->join('transaction_product_option as tpo', 't.id', 'tpo.transaction_id')
            ->join('product_option as po','tpo.product_option_id', 'po.id')
            ->join('product as p','po.product_id', 'p.id')
            ->where('p.name', 'Clubhouse Pro Membership')
            ->whereNull('linked_user_id')
            ->where('t.subscription_active_flag', true)
            ->where('t.created_at', '>', (new \DateTime('midnight'))->sub(new \DateInterval('P30D')))
            ->selectSub(function ($query) {
                $query->selectRaw('DATE(t.created_at)');
            }, 'clubhouse_subscription_activated_date')->get();

        $manually_added_clubhouse_users = User::select('user.*')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('role_code', 'administrator');
            })->whereHas('profile', function ($query) {
                $query->where('email_preference_marketing', true);
            })->join('role_user as ru', 'user.id', 'ru.user_id')
            ->whereNotIn('id', function($query) {
                $query->select('user_id')->from('transaction as t')
                  ->join('transaction_product_option as tpo', 't.id', 'tpo.transaction_id')
                  ->join('product_option as po','tpo.product_option_id', 'po.id')
                  ->join('product as p','po.product_id', 'p.id')
                  ->where('t.subscription_active_flag', true)
                  ->where('p.name', 'Clubhouse Pro Membership');
            })
            ->whereNull('linked_user_id')
            ->where('ru.role_code', 'clubhouse')
 			->where('ru.created_at', '>', (new \DateTime('midnight'))->sub(new \DateInterval('P30D')))
            ->selectSub(function ($query) {
                $query->selectRaw('DATE(ru.created_at)');
            }, 'clubhouse_subscription_activated_date')->get();

        foreach ($clubhouse_subscription_users->merge($manually_added_clubhouse_users) as $user) {
            if ($user->clubhouse_subscription_activated_date == (new \DateTime('30 days ago midnight'))->format('Y-m-d')) {
                Mail::to($user)->send(new ClubhouseFollowup($user, 'first_30'));
            } else if ($user->clubhouse_subscription_activated_date == (new \DateTime('21 days ago midnight'))->format('Y-m-d')) {
                Mail::to($user)->send(new ClubhouseFollowup($user, 'career_services'));
            } else if ($user->clubhouse_subscription_activated_date == (new \DateTime('14 days ago midnight'))->format('Y-m-d')) {
                Mail::to($user)->send(new ClubhouseFollowup($user, 'webinars'));
            } else if ($user->clubhouse_subscription_activated_date == (new \DateTime('10 days ago midnight'))->format('Y-m-d')) {
                Mail::to($user)->send(new ClubhouseFollowup($user, 'networking'));
            } else if ($user->clubhouse_subscription_activated_date == (new \DateTime('7 days ago midnight'))->format('Y-m-d')) {
                Mail::to($user)->send(new ClubhouseFollowup($user, 'connected'));
            }
        }

        $free_users = User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('role_code', array('administrator', 'clubhouse'));
            })->whereHas('profile', function ($query) {
                $query->where('email_preference_marketing', true);
            })->whereNull('linked_user_id')
            ->where('user.created_at', '>', (new \DateTime('midnight'))->sub(new \DateInterval('P30D')))->get();

        foreach ($free_users as $user) {
             $create_date = $user->created_at->setTime(0,0,0);
             if ($create_date == new \DateTime('30 days ago midnight')) {
                 Mail::to($user)->send(new FreeUserFollowup($user, 'first_30'));
             } else if ($create_date == new \DateTime('7 days ago midnight')) {
                 Mail::to($user)->send(new FreeUserFollowup($user, 'content'));
             } else if ($create_date == new \DateTime('3 days ago midnight')) {
                 Mail::to($user)->send(new FreeUserFollowup($user, 'benefits'));
             }
        }

        $reengagement_users = User::whereDoesntHave('roles', function ($query) {
                $query->whereIn('role_code', array('administrator', 'clubhouse', 'clubhouse_collaborator'));
            })->whereHas('profile', function ($query) {
                $query->where('email_preference_marketing', true);
            })->whereRaw('DATE(last_login_at) = DATE(DATE_SUB(NOW(), INTERVAL 60 DAY))')->get();

        foreach ($reengagement_users as $user) {
            Mail::to($user)->send(new FreeUserFollowup($user, 'reengagement'));
        }
    }

    /**
     * New users that have not signed up for a PRO account ~30 minutes after registering will receive the new free user email
     */
    public static function sendNewUserEmails()
    {
        $users = User::with('roles')
            ->whereDoesntHave('roles', function ($query) {
                $query->whereIn('role_code', array('administrator', 'clubhouse', 'clubhouse_collaborator'));
            })->where('created_at', '>', new \DateTime('1 hour ago'))
              ->where('created_at', '<=', new \DateTime('30 minutes ago'))->get();

        foreach ($users as $user) {
            Mail::to($user)->send(new UserRegistered($user));
        }
    }

    /**
     * Send an email to all users whose email preferences match the recently posted job's disciplines
     */
    public static function sendNewJobTypeMatchPostedEmails($date_since)
    {
        $jobs = Job::with('tags')->where('created_at', '>', $date_since)->get();
        $job_users = array();

        foreach ($jobs as $job) {
            $users = User::whereHas('profile.emailPreferenceTagTypes', function ($query) use ($job) {
                $query->where('type', 'job')->whereIn('tag_name', $job->tags->pluck('name'));
            })->whereHas('profile', function($query) {
                $query->where('email_preference_new_job', true);
            })->get();

            foreach ($users as $user) {
                if (!isset($job_users[$user->id])) {
                    $job_users[$user->id] = array(
                        'user' => $user,
                        'jobs'=> array()
                    );
                }
                $job_users[$user->id]['jobs'][] = $job;
            }
        }
        Log::info('Sending notifications for new jobs to '.count($job_users).' users.');
        foreach ($job_users as $job_user) {
            Mail::to($job_user['user'])->send(new NewJobTypeMatchPosted($job_user['user'], ...$job_user['jobs']));
        }
    }

    /**
     * Send an update of new Clubhouse content to all users who have opted in
     */
    public static function sendNewClubhouseContentEmails($date_since, $emails = null)
    {
        // Uncomment all toSql statements to reveal queries if Bob asks what's coming in the email

        $new_webinars_query = Product::with('tags')
            ->where('active', true)
            ->whereHas('tags', function ($query) {
                $query->whereIn('name', array('Webinar', '#SameHere'));
            });
        $new_webinars = $new_webinars_query->get();

        $new_webinar_recordings_query = Product::with(['tags', 'options'])
            ->where('active', false)
            ->whereHas('tags', function ($query) {
                $query->whereIn('name', array('Webinar', '#SameHere'));
            })->whereHas('options', function ($query) use ($date_since) {
                // We don't store the date that the webinar was marked inactive,
                // so we need to assume that the webinar was marked inactive on the date of the webinar,
                // taken from the product option's name.
                // If this has not been formatted as expected, we can't pull that info
                $query->whereRaw("STR_TO_DATE(name, '%M %e, %Y') >= '".$date_since->format('Y-m-d')."'")
                      ->whereRaw("STR_TO_DATE(name, '%M %e, %Y') < '".(new \DateTime('now'))->format('Y-m-d')."'");
            });
        $new_webinar_recordings = $new_webinar_recordings_query->get();

        $new_blog_posts_query = Post::with('tags')->where('created_at', '>', $date_since);
        $new_blog_posts = $new_blog_posts_query->get();

        $new_mentors_query = Mentor::where('active', true)->where('activated_at', '>', $date_since);
        $new_mentors = $new_mentors_query->get();

        $new_training_videos_query = Product::with('tags')
            ->where('active', true)
            ->whereHas('tags', function ($query) {
                $query->where('name', 'Training Video');
            })->where('created_at', '>', $date_since);
        $new_training_videos = $new_training_videos_query->get();

        if ($new_webinars->isEmpty()
            && $new_webinar_recordings->isEmpty()
            && $new_blog_posts->isEmpty()
            && $new_mentors->isEmpty()
            && $new_training_videos->isEmpty()) {
            Log::info('New clubhouse content email will not be sent. No new content has been found.');
            return;
        }

        if (is_null($emails) || count($emails) < 1) {
            $users = User::whereHas('profile', function ($query) use ($new_webinars,
                                                                      $new_webinar_recordings,
                                                                      $new_blog_posts,
                                                                      $new_mentors,
                                                                      $new_training_videos) {
                    $query->where(function ($query) use ($new_webinars,
                                                         $new_webinar_recordings,
                                                         $new_blog_posts,
                                                         $new_mentors,
                                                         $new_training_videos) {
                        if ($new_webinars->isNotEmpty() || $new_webinar_recordings->isNotEmpty()) {
                            $query->where('email_preference_new_content_webinars', true);
                        }
                        if ($new_blog_posts->isNotEmpty()) {
                            $query->orWhere('email_preference_new_content_blogs', true);
                        }
                        if ($new_mentors->isNotEmpty()) {
                            $query->orWhere('email_preference_new_content_mentors', true);
                        }
                        if ($new_training_videos->isNotEmpty()) {
                            $query->orWhere('email_preference_new_content_training_videos', true);
                        }
                    });
                });
            $users = $users->get();
        } else {
            $users = User::whereIn('email', $emails)->get();
        }

        Log::info('Sending new clubhouse content emails to '.$users->count().' users');
        foreach ($users as $user) {
            Mail::to($user)->send(new NewClubhouseContentEmail($user,
                                                               $new_webinars,
                                                               $new_webinar_recordings,
                                                               $new_blog_posts,
                                                               $new_mentors,
                                                               $new_training_videos));
        }
    }

    /**
     * Send a followup email to job contacts who haven't responded to a ContactInterestRequest
     */
    public static function sendContactJobFollowupEmails()
    {
        $normal_followup_contacts =
            ContactJob::where(DB::raw('DATE(job_interest_request_date)'), (new \DateTime('-2 days'))->format('Y-m-d'))
                ->whereNull('job_interest_response_code')
                ->get();

        foreach ($normal_followup_contacts as $contact_job) {
            Mail::to($contact_job->contact)->send(new ContactJobFollowup($contact_job, false));
        }

        $final_followup_contacts =
            ContactJob::where(DB::raw('DATE(job_interest_request_date)'), (new \DateTime('-5 days'))->format('Y-m-d'))
                ->whereNull('job_interest_response_code')
                ->get();

        foreach ($final_followup_contacts as $contact_job) {
            Mail::to($contact_job->contact)->send(new ContactJobFollowup($contact_job, true));
        }
    }
}
