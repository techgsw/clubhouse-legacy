<?php

namespace App\Console\Commands;

use App\Providers\MailchimpServiceProvider;
use App\RoleUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddProUsersToMailChimp extends Command
{
    protected $signature = 'pro:add {--after=}';

    public function handle()
    {
        try {
            $after = $this->option('after')
                ? Carbon::parse($this->option('after'))
                : null;
        } catch (\Exception $e) {
            echo 'Unable to parse date' . PHP_EOL;

            return;
        }

        $proMembers = RoleUser::where('role_code', 'clubhouse')
            ->whereNotNull('created_at');

        if ($after) {
            $proMembers->where('created_at', '>=', $after);
        }

        $proMembers->orderBy('created_at', 'desc')->get();

        $count = 0;
        $proMembers->each(function ($roleUser) use (&$count) {
            $user = User::find($roleUser->user_id);
            if (! MailchimpServiceProvider::doesUserEmailExistInList($user, env("MAILCHIMP_PRO_LIST_ID"))) {
                echo $user->email . PHP_EOL;

                try {
                    MailchimpServiceProvider::addToMailchimp($user, env("MAILCHIMP_PRO_LIST_ID"));
                    echo '...Added to MailChimp!' . PHP_EOL;

                    $count++;
                } catch (\Exception $e) {
                    echo $e->getMessage() . PHP_EOL;
                }
            }
        });

        echo $count . ' users added.' . PHP_EOL;
    }
}
