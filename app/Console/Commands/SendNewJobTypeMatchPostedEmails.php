<?php

namespace App\Console\Commands;

use App\Providers\EmailServiceProvider;
use Illuminate\Console\Command;

class SendNewJobTypeMatchPostedEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:new-job-type-match {since}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users whose email preferences match jobs posted since the specified date';

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
        $since = $this->argument('since');
        $since = new \DateTime($since);
        $since->setTime(0, 0, 0);

        EmailServiceProvider::sendNewJobTypeMatchPostedEmails($since);
    }
}
