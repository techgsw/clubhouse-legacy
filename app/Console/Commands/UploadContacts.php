<?php

namespace App\Console\Commands;

use Mail;
use App\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class UploadContacts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:contacts {filepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upload contacts given CSV file.';

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
        // TODO 107
        echo "Uploading contacts from " . $this->argument('filepath') . "...\n";

        // Just write it all here
    }
}
