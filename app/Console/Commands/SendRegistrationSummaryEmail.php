<?php

namespace App\Console\Commands;

use Mail;
use App\User;
use App\Providers\EmailServiceProvider;
use App\Mail\Admin\RegistrationSummary;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class SendRegistrationSummaryEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:registration-summary {start} {end?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send registration summary email.';

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
        $start = $this->argument('start');
        $start = new \DateTime($start);
        $start->setTime(0, 0, 0);

        $end = $this->argument('end');
        if ($end) {
            $end = new \DateTime($end);
            $end->setTime(23, 59, 59);
        } else {
            $end = clone $start;
            $end->setTime(23, 59, 59);
        }

        EmailServiceProvider::sendRegistrationSummaryEmail($start, $end);
    }
}
