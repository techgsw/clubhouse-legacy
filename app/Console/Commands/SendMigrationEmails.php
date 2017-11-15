<?php

namespace App\Console\Commands;

use Mail;
use App\User;
use App\Mail\UserMigration;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;

class SendMigrationEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:user-migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send user migratino emails.';

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
        $users = User::where('password', 'invalid-hash')->get();
        
        foreach ($users as $user) {
            try {
                Mail::to($user)->send(new UserMigration($user));
            } catch (Exception $e) {
                dd($e);
                //Log here
            }
        }
    }
}
