<?php

namespace App\Providers;

use App\User;
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
     * 3. Update their entry ONLY IF their Mailchimp info was last updated after $since
     * 4. If they aren't in the Mailchimp list at all (or are listed as unsubscribed/archived/cleaned), remove their hash
     *
     * @param \DateTime  $since                Only update entries changed after this date/time.
     * @param int        $offset               Pull entries after this number
     * @param array      $subsbcribed_id_list  Keep track of user IDs that are present in Mailchimp.
     **/
    public static function refreshMailchimpSubscriberHashes(
        \DateTime $since = null,
        int $offset = 0,
        array $subscribed_id_list = []
    ) {
        Log::info('Starting refresh of mailchimp subscriber hashes'
                  .($since ? ' since '.$since->format('Y-m-d H:i:s') : '')
                  .($offset ? ' with offset '.$offset : ''));

        // This is Mailchimp's current limit for this request.
        $limit = 1000;

        $api_key = env("MAILCHIMP_API_KEY");
        $list_id = env("MAILCHIMP_LIST_ID");
        $query_params = [
            'fields' => 'id,email_address',
            'count' => $limit,
            'offset' => $offset
        ];
        if ($since) {
            $query_params['since_last_changed'] = $since->format(DATE_ATOM);
        }
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
                    if (!is_null($since) && (new \DateTime($member->last_changed)) >= $since) {
                        $email_hash_id_map[$member->email_address] = $member->id;
                    } else {
                        // This user has not had their mailchimp settings changed.
                        // We don't need to update anything but we want to know the user exists in mailchimp.
                        $email_hash_id_map[$member->email_address] = false;
                    }
                }
            }

            $users = User::whereIn('email', array_keys($email_hash_id_map));

            foreach($users as $user) {
                // $email_hash_id_map should always have a value for the user's email, given the query
                if ($email_hash_id_map[$user->email] !== false) {
                    $user->mailchimp_subscriber_hash = $email_hash_id_map[$user->email];
                    $user->save();
                }
                $subscribed_id_list[] = $user->id;
            }
        }

        if ($response->total_items == $limit) {
            // Check for more entries
            self::refreshMailchimpSubscriberHashes($since, $offset + $limit, $subscribed_id_list);
        } else {
            // We're done. Remove mailchimp_subscriber_hash from anyone not present in the list
            User::whereNotIn('id', $subscribed_id_list)
                  ->update(['mailchimp_subscriber_hash' => null]);
        }
    }

    public static function addToMailchimp(User $user)
    {
        $api_key = env("MAILCHIMP_API_KEY");
        $list_id = env("MAILCHIMP_LIST_ID");
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

    public static function deleteFromMailchimp(User $user)
    {
        if (!$user->mailchimp_subscriber_hash) {
            throw new \Exception('Mailchimp subscriber hash not found for user '.$user->id);
        }

        $api_key = env("MAILCHIMP_API_KEY");
        $list_id = env("MAILCHIMP_LIST_ID");
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
}
