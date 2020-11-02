<?php

namespace App\Console\Commands;

use App\Mentor;
use App\Providers\EmailServiceProvider;
use Illuminate\Console\Command;

class CheckInvalidMentorCalendlyLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:checkcalendlylinks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Checks all of the current active mentors' Calend.ly links and sends an email to Bob if any are invalid";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $mentors = Mentor::where('active', 1)->get();

        $invalid_mentors = array();

        foreach ($mentors as $mentor) {
            if (!$mentor->isCalendlyLinkValid()) {
                $invalid_mentors[] = $mentor;
            }
        }

        if (!empty($invalid_mentors)) {
            EmailServiceProvider::sendInvalidMentorCalendlyLinkNotification($invalid_mentors);
        }
    }
}
