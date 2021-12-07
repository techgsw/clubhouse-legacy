<?php

namespace App\Console\Commands;

use App\Providers\MailchimpServiceProvider;
use Illuminate\Console\Command;

class RefreshMailchimpSubscriberHashes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:refreshMailchimpSubscriberHashes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Refresh users' mailchimp_subscriber_hash based on the newsletter list in mailchimp since a specific date/time (\"YYYY-MM-DD HH:MM:SS\")";

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
        MailchimpServiceProvider::refreshMailchimpSubscriberHashes();
    }
}
