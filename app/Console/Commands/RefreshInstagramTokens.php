<?php

namespace App\Console\Commands;

use App\Providers\SocialMediaServiceProvider;
use Illuminate\Console\Command;

class RefreshInstagramTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:refreshInstagramTokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes the CLUBHOUSE_INSTAGRAM_ACCESS_TOKEN and INSTAGRAM_ACCESS_TOKEN environment variables';

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
        $env_file = base_path('.env');
        copy($env_file, $env_file.'.BACKUP');

        SocialMediaServiceProvider::refreshInstagramToken(
            env('CLUBHOUSE_INSTAGRAM_ACCESS_TOKEN'),
            'CLUBHOUSE_INSTAGRAM_ACCESS_TOKEN'
        );

        SocialMediaServiceProvider::refreshInstagramToken(
            env('INSTAGRAM_ACCESS_TOKEN'),
            'INSTAGRAM_ACCESS_TOKEN'
        );
    }
}
