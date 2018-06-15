<?php

namespace App\Providers;

use App\Contact;
use App\Organization;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class OrganizationServiceProvider extends ServiceProvider
{
    public static function mapContacts(Organization $organization)
    {
        $match_count = 0;

        // Contacts with organization field, but no ContactOrganization
        $contacts = Contact::whereNotNull('organization')
            ->whereNotIn('id', DB::table('contact_organization')->pluck('contact_id'))
            ->each(function (Contact $contact) use ($organization, &$match_count) {
                if (empty($contact->organization)) {
                    return false;
                }

                $contact_organization_name = trim(strtolower($contact->organization));
                $organization_name = trim(strtolower($organization->name));

                if ($contact_organization_name == $organization_name) {
                    $contact->organizations()->attach($organization->id);
                    $match_count++;
                    return true;
                }

                // TODO check organization aliases
            });

        return $match_count;
    }
}
