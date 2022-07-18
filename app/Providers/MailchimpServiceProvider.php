<?php

namespace App\Providers;

use App\User;
use Exception;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class MailchimpServiceProvider extends ServiceProvider
{
    /**
     * Recursively update users' mailchimp_subscriber_hash from the Mailchimp API
     *
     * This method does a few things:
     *
     * 1. Pull all Mailchimp subscribers from the API
     * 2. See if they exist in the database
     * 3. Update their entry
     * 4. OR if they aren't in the Mailchimp list at all (or are listed as unsubscribed/archived/cleaned), remove their hash
     *
     * @param int        $offset               Pull entries after this number
     * @param array      $subsbcribed_id_list  Keep track of user IDs that are present in Mailchimp.
     **/
    public static function refreshMailchimpSubscriberHashes(
        int $offset = null,
        array $subscribed_id_list = []
    ) {
        $offset = (! $offset) ? 0 : $offset;
        
        Log::info('Starting refresh of mailchimp subscriber hashes'
                  .($offset ? ' with offset '.$offset : ''));

        // This is Mailchimp's current limit for this request.
        $limit = 1000;

        $api_key = env("MAILCHIMP_API_KEY");
        $list_id = env("MAILCHIMP_LIST_ID");
        $query_params = [
            'fields' => 'members.id,members.last_changed,members.status,members.email_address,total_items',
            'count' => $limit,
            'offset' => $offset
        ];
        $url = "https://us9.api.mailchimp.com/3.0/lists/{$list_id}/members?".http_build_query($query_params);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: apikey {$api_key}"
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            throw new \Exception('Error from Mailchimp trying to refresh hashes');
        }
        $response = json_decode($response);

        if ($response && !isset($response->members) && $response->status <= 400) {
            throw new \Exception('Error from Mailchimp trying to refresh hashes : '.$response->detail);
        }

        if ($response->total_items > 0) {
            $email_hash_id_map = [];
            foreach ($response->members as $member) {
                if (in_array($member->status, ['subscribed', 'pending', 'transactional'])) {
                    // Note that emails are being stored as lowercase because their case in the db may be different
                    $email_hash_id_map[strtolower($member->email_address)] = $member->id;
                }
            }

            $users = User::whereIn('email', array_keys($email_hash_id_map))->get();

            foreach($users as $user) {
                // $email_hash_id_map should always have a value for the user's email, given the query
                if ($email_hash_id_map[strtolower($user->email)] !== false) {
                    $user->mailchimp_subscriber_hash = $email_hash_id_map[strtolower($user->email)];
                    $user->save();
                }
                $subscribed_id_list[] = $user->id;
            }
        }

        if ($response->total_items == $limit) {
            // Check for more entries
            self::refreshMailchimpSubscriberHashes($offset + $limit, $subscribed_id_list);
        } else {
            // We're done. Remove mailchimp_subscriber_hash from anyone not present in the list
            User::whereNotIn('id', $subscribed_id_list)
                  ->update(['mailchimp_subscriber_hash' => null]);
        }
    }

    public static function addToMailchimp(User $user, $list_id = null)
    {
        $api_key = env("MAILCHIMP_API_KEY");
        $list_id = (! $list_id) ? env("MAILCHIMP_LIST_ID") : $list_id;
        $url = "https://us9.api.mailchimp.com/3.0/lists/{$list_id}/members";
        $fields = array(
            "email_address" => $user->email,
            "email_type" => "html",
            "status" => "subscribed",
            "merge_fields" => [
                "FNAME" => $user->first_name,
                "LNAME" => $user->last_name,
            ]
        );
        $json_body = json_encode($fields);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: apikey {$api_key}"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_body);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            throw new \Exception('Error from Mailchimp trying to add user '.$user->id);
        }
        $response = json_decode($response);

        if ($response) {
            if ($response->status != 'subscribed') {
                if ($response->detail) {
                    throw new \Exception('Error from Mailchimp trying to add user '.$user->id.': '.$response->detail);
                } else {
                    throw new \Exception('Error from Mailchimp trying to add user '.$user->id.': Mailchimp response status is '.$response->status);
                }
            }

            if (!$response->id) {
                throw new \Exception('Error from Mailchimp trying to add user '.$user->id.': No subscriber hash returned.');
            }

            $user->mailchimp_subscriber_hash = $response->id;
            $user->save();
        } else {
            throw new \Exception('Error from Mailchimp trying to add user '.$user->id.': No response returned.');
        }
    }

    public static function deleteFromMailchimp(User $user, $list_id = null)
    {
        if (!$user->mailchimp_subscriber_hash) {
            throw new \Exception('Mailchimp subscriber hash not found for user '.$user->id);
        }

        $api_key = env("MAILCHIMP_API_KEY");
        $list_id = (! $list_id) ? env("MAILCHIMP_LIST_ID") : $list_id;
        $url = "https://us9.api.mailchimp.com/3.0/lists/{$list_id}/members/{$user->mailchimp_subscriber_hash}/actions/delete-permanent";

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: apikey {$api_key}"
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === false) {
            throw new \Exception('Error from Mailchimp trying to delete user '.$user->id);
        }
        $response = json_decode($response);

        // Note that a 404 indicates that the user ID was not found and may have already been deleted.
        // We can skip this step and delete the hash if that's the case.
        if ($response && $response->status <= 400 && $response->status != 404) {
            throw new \Exception('Error from Mailchimp trying to delete user '.$user->id.': '.$response->detail);
        }

        $user->mailchimp_subscriber_hash = null;
        $user->save();
    }

    public static function addUserToProMembersList(User $user)
    {
        $proListId = env("MAILCHIMP_PRO_LIST_ID");

        if (! $proListId) {
            throw new \Exception('Missing MAILCHIMP_PRO_LIST_ID in .env');
        }

        self::addToMailchimp($user, $proListId);
    }
}
