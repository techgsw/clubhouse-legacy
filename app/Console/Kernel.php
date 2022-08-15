<?php

namespace App\Console;

use App\Providers\EmailServiceProvider;
use App\Providers\ImageServiceProvider;
use App\Providers\JobServiceProvider;
use App\Providers\MailchimpServiceProvider;
use App\Providers\StripeServiceProvider;
use App\Console\Commands\CheckInvalidMentorCalendlyLinks;
use App\Console\Commands\RefreshInstagramTokens;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\FormatPhones::class,
        Commands\MapContactsToOrganizations::class,
        Commands\PushToS3::class,
        Commands\SendMigrationEmails::class,
        Commands\SendInquirySummaryEmail::class,
        Commands\SendRegistrationSummaryEmail::class,
        Commands\SendNewJobTypeMatchPostedEmails::class,
        Commands\SendClubhouseNewContentEmails::class,
        Commands\UploadContacts::class,
        Commands\UpdateContacts::class,
        Commands\ReconcileContacts::class,
        Commands\GenerateInstagramToken::class,
        Commands\UploadOrganizations::class,
        Commands\LinkAccountsMatchingContactInfo::class,
        Commands\CheckInvalidMentorCalendlyLinks::class,
        Commands\RefreshInstagramTokens::class,
        Commands\AddProUsersToMailChimp::class,
        Commands\RefreshMailchimpSubscriberHashes::class,
        Commands\Dev\LocalizationScan::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $start = new \DateTime('yesterday');
            $start->setTime(17, 0, 0);
            $end = new \DateTime('today');
            $end->setTime(17, 0, 0);
            EmailServiceProvider::sendInquirySummaryEmail($start, $end);
        })->dailyAt('17:30');

        $schedule->call(function () {
            $start = new \DateTime('yesterday');
            $start->setTime(17, 0, 0);
            $end = new \DateTime('today');
            $end->setTime(17, 0, 0);
            EmailServiceProvider::sendRegistrationSummaryEmail($start, $end);
        })->dailyAt('17:30');

        $schedule->call(function () {
            JobServiceProvider::expireJobs();
        })->everyMinute();

        $schedule->call(function () {
            JobServiceProvider::sendExpirationReminder(10);
            JobServiceProvider::sendExpirationReminder(3);
        })->dailyAt('9:00');

        $schedule->call(function() {
            EmailServiceProvider::sendJobNoActionReminderEmails();
        })->weeklyOn(date('w', strtotime('Monday')), '07:00');

        if (env('APP_ENV') == 'production') {
            $schedule->call(function () {
                ImageServiceProvider::pushToS3();
            })->hourly();
        }

        $schedule->call(function () {
            $start = new \DateTime('yesterday');
            $start->setTime(8,30,0);
            EmailServiceProvider::sendFailedClubhousePaymentNotice($start);
        })->dailyAt('8:30');

        $schedule->call(function () {
            $start = new \DateTime('yesterday');
            $start->setTime(3,0,0);
            StripeServiceProvider::updateSubscriptionStatusesSince($start);
        })->dailyAt('3:00');

        $schedule->call(function () {
            $since = new \DateTime('first day of previous month');
            $since->setTime(9,0,0);
            EmailServiceProvider::sendMentorshipFollowupEmails($since);
        })->monthlyOn(1, '9:00');

        $schedule->command(CheckInvalidMentorCalendlyLinks::class)->dailyAt('8:00');

        $schedule->command(RefreshInstagramTokens::class)->cron('0 4 1,15 * *');

        $schedule->call(function() {
            EmailServiceProvider::sendFollowUpEmails();
        })->dailyAt('10:00');

        $schedule->call(function() {
            EmailServiceProvider::sendNewUserEmails();
        })->everyThirtyMinutes();

        $schedule->call(function() {
            $date_since = new \DateTime('-7 days');
            EmailServiceProvider::sendNewJobTypeMatchPostedEmails($date_since);
        })->weeklyOn(3, '8:00');

        $schedule->call(function() {
            $date_since = new \DateTime('-7 days');
            $date_since->setTime(0,0,0);
            EmailServiceProvider::sendNewClubhouseContentEmails($date_since);
        })->weeklyOn(1, '7:00');

        $schedule->call(function() {
            EmailServiceProvider::sendContactJobFollowupEmails();
        })->dailyAt('8:00');

        $schedule->call(function() {
            MailchimpServiceProvider::refreshMailchimpSubscriberHashes();
        })->dailyAt('2:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
