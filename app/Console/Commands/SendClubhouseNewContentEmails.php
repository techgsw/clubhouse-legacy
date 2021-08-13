<?php

namespace App\Console\Commands;

use App\Providers\EmailServiceProvider;
use Illuminate\Console\Command;

class SendClubhouseNewContentEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:new-clubhouse-content {since} {emails?*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users with new content created in theClubhouse since a specific date (YYYY-MM-DD). Optionally include email addresses to only send it to them.';

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

        $emails = $this->argument('emails');

        EmailServiceProvider::sendNewClubhouseContentEmails($since, $emails);
    }
}
