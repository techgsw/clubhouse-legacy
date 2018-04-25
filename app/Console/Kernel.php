<?php

namespace App\Console;

use App\Providers\EmailServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\FormatPhones::class,
        Commands\PushToS3::class,
        Commands\SendMigrationEmails::class,
        Commands\SendNewUserFollowUpEmails::class,
        Commands\SendInquirySummaryEmail::class,
        Commands\SendRegistrationSummaryEmail::class,
        Commands\UploadContacts::class
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
            $date = new \DateTime('now');
            $date->sub(new \DateInterval('P2D'));
            EmailServiceProvider::sendNewUserFollowUpEmails($date);
        })->dailyAt('08:00');

        $schedule->call(function () {
            $start = new \DateTime('yesterday');
            $start->setTime(0, 0, 0);
            $end = clone $start;
            $end->setTime(23, 59, 59);
            EmailServiceProvider::sendInquirySummaryEmail($start, $end);
        })->dailyAt('09:00');

        $schedule->call(function () {
            $start = new \DateTime('yesterday');
            $start->setTime(0, 0, 0);
            $end = clone $start;
            $end->setTime(23, 59, 59);
            EmailServiceProvider::sendRegistrationSummaryEmail($start, $end);
        })->dailyAt('09:00');

        // $schedule->call(function () {
        //     ImageServiceProvider::pushToS3();
        // })->everyFifteenMinutes();
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
