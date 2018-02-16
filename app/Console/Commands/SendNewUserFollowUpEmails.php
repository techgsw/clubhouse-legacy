<?php

namespace App\Console\Commands;

use Mail;
use App\User;
use App\Providers\EmailServiceProvider;
use App\Mail\NewUserFollowUp;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class SendNewUserFollowUpEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:follow-up {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send new user follow-up emails.';

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
        $date = $this->argument('date');
        if ($date) {
            $date = new \DateTime($date);
        } else {
            $date = new \DateTime('now');
            $date->sub(new \DateInterval('P2D'));
        }
        EmailServiceProvider::sendNewUserFollowUpEmails($date);
    }
}
