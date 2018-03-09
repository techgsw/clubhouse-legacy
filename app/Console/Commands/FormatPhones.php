<?php

namespace App\Console\Commands;

use App\Contact;
use App\Profile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FormatPhones extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'format:phones';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Format all phone numbers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function formatPhone($model) {
        $id = $model->id;
        $before = $model->phone;
        $after = preg_replace("/[^\d]/", "", $before);
        if ($after == $before) {
            return;
        }

        if (strlen($after) == 10 || (strlen($after) == 11 && $after[0] === '1')) {
            echo $model->id . ":" . $before . " => " . $after . "\n";
            $model->phone = $after;
            $model->save();
        } else {
            echo $model->id . ":" . $before . "\n";
        }

        return;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        echo "Contacts\n";
        Contact::whereNotNull('phone')->each(function ($contact) {
            $this->formatPhone($contact);
        });
        echo "Profiles\n";
        Profile::whereNotNull('phone')->each(function ($profile) {
            $this->formatPhone($profile);
        });
    }
}
