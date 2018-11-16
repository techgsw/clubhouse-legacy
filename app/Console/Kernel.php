<?php

namespace App\Console;

use App\Providers\EmailServiceProvider;
use App\Providers\ImageServiceProvider;
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
        Commands\SendNewUserFollowUpEmails::class,
        Commands\SendInquirySummaryEmail::class,
        Commands\SendRegistrationSummaryEmail::class,
        Commands\UploadContacts::class,
        Commands\GenerateInstagramToken::class,
        Commands\UploadOrganizations::class
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

        if (env('APP_ENV') == 'production') {
            $schedule->call(function () {
                ImageServiceProvider::pushToS3();
            })->hourly();
        }
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
