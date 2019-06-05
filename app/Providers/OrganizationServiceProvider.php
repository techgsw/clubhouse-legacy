<?php

namespace App\Providers;

use App\Contact;
use App\Organization;
use App\Http\Controller\OrganizationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

    private static function getOrganizationChildren($organization, &$orgs = array())
    {   
        $orgs[] = $organization;

        $organizations = DB::table('organization as o')
                            ->select('*')
                            ->where('o.parent_organization_id', '=', $organization->id)
                            ->get();
        
        foreach ($organizations as $organization) {
            OrganizationServiceProvider::getOrganizationChildren($organization, $orgs);
        }
        
        return $orgs;
    }

    public static function all()
    {
        $user = Auth::user();

        if ($user->can('view-admin-jobs', $user)) {
            $organizations = DB::table('organization')
                                    ->select('*')
                                    ->get();
        } else {
            $organization = DB::table('contact_organization')
                                    ->select('*')
                                    ->where('contact_id', '=', $user->contact->id)
                                    ->join('organization', 'organization.id', '=', 'organization_id')
                                    ->first();
            if (!is_null($organization)) {
                $organizations = OrganizationServiceProvider::getOrganizationChildren($organization);
            } else {
                return $organization;
            }
        }

        // $this->authorize('view-organization');
        return $organizations;
    }
}
