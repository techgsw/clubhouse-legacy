<?php

namespace App\Providers;

use Mail;
use App\Email;
use App\Inquiry;
use App\Job;
use App\Mentor;
use App\User;
use App\ProductOption;
use App\Mail\PurchaseNotification;
use App\Mail\NewUserFollowUp;
use App\Mail\Admin\InquirySummary;
use App\Mail\Admin\RegistrationNotification;
use App\Mail\Admin\RegistrationSummary;
use App\Mail\MentorshipRequest;
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

    public static function sendNewUserFollowUpEmails(\DateTime $date)
    {
        $users = User::registeredOn($date);

        foreach ($users->get() as $user) {
            Mail::to($user)->send(new NewUserFollowUp($user));
        }
    }

    public static function sendMentorshipRequestEmails(User $mentee, Mentor $mentor, array $dates)
    {
        // Confirm request with user
        Mail::to($mentee)->send(new MentorshipRequest($mentor, $mentee, $dates));

        // Alert admins about request
        $users = User::join('email_user', 'user.id', 'email_user.user_id')
            ->join('email', 'email_user.email_id', 'email.id')
            ->where('email.code', 'mentorship_requests')
            ->select('user.*')
            ->get();

        Mail::to($users)->send(new \App\Mail\Admin\MentorshipRequest($mentor, $mentee, $dates));
    }

    public static function addToMailchimp(User $user)
    {
        $api_key = env("MAILCHIMP_API_KEY");
        $list_id = env("MAILCHIMP_LIST_ID");
        $url = "https://us9.api.mailchimp.com/3.0/lists/{$list_id}/members";
        $fields = array(
            "email_address" => $user->email,
            "email_type" => "html",
            "status" => "subscribed",
            "merge_fields" => [
                "FNAME" => $user->first_name,
                "LNAME" => $user->last_name,
            ]
        );
        $json = json_encode($fields);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: apikey {$api_key}"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $response = curl_exec($ch);

        return $response;
    }
}
