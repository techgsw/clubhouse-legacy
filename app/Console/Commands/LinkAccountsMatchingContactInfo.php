<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class LinkAccountsMatchingContactInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:link-accounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Link accounts whose name and phone OR name and address line 1 matches.';

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
        $duplicates_by_name = User::with('contact')->whereRaw('(first_name, last_name) IN
        (SELECT first_name, last_name FROM user GROUP BY first_name, last_name HAVING count(*) > 1)')
            // we want to order by first_name and last_name so we can loop through logical groupings in one go
            ->orderBy('first_name', 'DESC')
            ->orderBy('last_name', 'DESC')
            // THEN we want to order by created_at to make sure the primary user is the one that was created the most recently
            ->orderBy('created_at', 'DESC')
            ->get();

        $duplicate_group = array();

        $count = 0;

        foreach($duplicates_by_name as $duplicate) {
            if (empty($duplicate_group)) {
                // most likely the first element
                $duplicate_group []= $duplicate;
            } else if ($duplicate_group[0]->first_name == $duplicate->first_name && $duplicate_group[0]->last_name == $duplicate->last_name) {
                // we have a match by name, see if address or phone match and if so we can add them to the list
                $duplicates_match = false;
                foreach ($duplicate_group as $user) {
                    if (!is_null($user->contact) && !is_null($duplicate->contact)) {
                        if ((!is_null($user->contact->phone) && $user->contact->phone == $duplicate->contact->phone)
                            || (!empty($user->contact->address) && !is_null($user->contact->address->first()->line1) && $user->contact->address->first()->line1 == $duplicate->contact->address->first()->line1)
                            || (!empty($user->contact->address) && !is_null($user->contact->address->first()->city) && $user->contact->address->first()->city == $duplicate->contact->address->first()->city)
                            || (!empty($user->contact->address) && !is_null($user->contact->address->first()->postal_code) && $user->contact->address->first()->postal_code == $duplicate->contact->address->first()->postal_code)
                            || (!empty($user->contact->organization) && $user->contact->organization == $duplicate->contact->organization)
                            || (!empty($user->contact->title) && $user->contact->title == $duplicate->contact->title)
                        ) {
                            $duplicates_match = true;
                        }
                    }
                }
                if ($duplicates_match) {
                    $duplicate_group []= $duplicate;
                    echo $duplicate->first_name.','. $duplicate->last_name.','. $duplicate->email.','. $duplicate->contact->phone.','. $duplicate->contact->organization.PHP_EOL;
                }
            } else {
                // we're at the end of the name matches, see if we have enough users to link accounts, then clear the array and add the new user
                if (count($duplicate_group) > 1) {
                    $duplicate_group[0]->linkUsersToThisAccount(array_slice($duplicate_group, 1));
                    $count += count($duplicate_group);
                }
                $duplicate_group = array($duplicate);
            }
        }

        echo "$count user records have been linked.";
    }
}
