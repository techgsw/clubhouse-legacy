<?php

namespace App\Http\Controllers;

use App\Address;
use App\Image;
use App\League;
use App\LeagueOrganization;
use App\Organization;
use App\OrganizationType;
use App\Message;
use App\User;
use App\Exceptions\SBSException;
use App\Providers\EmailServiceProvider;
use App\Providers\ImageServiceProvider;
use App\Providers\OrganizationServiceProvider;
use App\Providers\UtilityServiceProvider;
use App\Http\Requests\Organization\Store;
use App\Http\Requests\Organization\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use \Exception;

class OrganizationController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $this->authorize('view-admin-organizations');

        $organizations = Organization::with(['addresses', 'jobs', 'contacts'])
            ->search($request)
            ->orderBy('name', 'asc')
            ->paginate(24);

        return view('organization/index', [
            'breadcrumb' => [
                'Admin' => '/admin',
                'Organization' => '/admin/organization',
            ],
            'organizations' => $organizations
        ]);
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-organization');

        $organization_types = OrganizationType::all();
        $leagues = League::all();

        return view('organization/create', [
            'organization_types' => $organization_types,
            'leagues' => $leagues,
            'breadcrumb' => [
                'Home' => '/admin',
                'Organization' => '/admin/organization',
                'Create' => '/organization/create'
            ]
        ]);
    }

    public function store(Store $request)
    {
        $duplicate = Organization::where('name', $request->name)->first();
        if ($duplicate) {
            Log::error((new SBSException('Found an existing organization named '.$request->name))->getMessage());
            $request->session()->flash('message', new Message(
                "Found an existing organization named {$request->name}",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back();
        }

        try {
            $organization = DB::transaction(function () use ($request) {
                $user = Auth::user();
                $organization = Organization::create([
                    'name' => $request->name,
                    'user_id' => $user->id,
                ]);

                if ($request->parent_orgnization_id) {
                    $organization->parent_organization_id = $request->parent_organization_id;
                }
                if ($request->organization_type_id) {
                    $organization->organization_type_id = (int)$request->organization_type_id;
                }
                $organization->save();

                if (!$user->roles->contains('administrator')) {
                    if (count($user->contact->organizations) < 1) {
                        $user->contact->organizations()->attach($organization->id);
                        $user->contact->organization = $organization->name;
                        $user->contact->save();
                    } else {
                        throw new SBSException('This account is already associated with an organization.');
                    }
                }

                if ($request->organization_type_id == 2 /* League */) {
                    // Create
                    $league = new League();
                    $league->abbreviation = request('abbreviation') ?: $organization->name;
                    $league->organization_id = $organization->id;
                    $league->save();
                } else {
                    // Not a league
                    $league = League::where('id', request('league_id'))->first();
                    if ($league) {
                        $organization->leagues()->sync([$league->id]);
                    }
                }

                $address = new Address([
                    'name' => $request->name ?: null,
                    'line1' => $request->line1 ?: null,
                    'line2' => $request->line2 ?: null,
                    'city' => $request->city ?: null,
                    'state' => $request->state ?: null,
                    'postal_code' => $request->postal_code ?: null,
                    'country' => $request->country ?: null,
                ]);
                $address->save();

                $organization->addresses()->attach($address);
                $organization->save();

                if ($image_file = request()->file('image_url')) {
                    $image = ImageServiceProvider::saveFileAsImage(
                        $image_file,
                        $filename = UtilityServiceProvider::encode($organization->name).'-sports-business-solutions',
                        $directory = 'organization/'.$organization->id
                    );

                    $organization->image()->associate($image);
                    $organization->save();
                }

                if (!$user->roles->contains('administrator')) {
                    try {
                        EmailServiceProvider::sendUserOrganizationCreateNotificationEmail($user, $organization);
                    } catch (\Throwable $e) {
                        Log::error($e->getMessage());
                    }
                }

                return $organization;
            });
        } catch (SBSException $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                $e->getMessage(),
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                "Unable to save organization. Please check all fields and try again.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back();
        }

        try {
            $count = OrganizationServiceProvider::mapContacts($organization);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        $request->session()->flash('message', new Message(
            "Congratulations, your organization has been created!",
            "success",
            $code = null,
            $icon = "check_circle"
        ));

        return back();
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $this->authorize('view-organization');

        $organization = Organization::with(['addresses', 'jobs'])->find($id);
        if (!$organization) {
            return abort(404);
        }

        $jobs = $organization->jobs()->paginate(10);

        return view('organization/show', [
            'organization' => $organization,
            'jobs' => $jobs,
            'breadcrumb' => [
                'Admin' => '/admin',
                'Organization' => '/admin/organization',
                "$organization->name" => "/organization/{$organization->id}"
            ]
        ]);
    }

    /**
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $organization = Organization::find($id);
        if (!$organization) {
            return redirect()->back()->withErrors(['msg' => 'Could not find organization']);
        }

        $this->authorize('edit-organization', $organization);

        $organization_types = OrganizationType::all();
        $leagues = League::all();

        return view('organization/edit', [
            'organization' => $organization,
            'organization_types' => $organization_types,
            'leagues' => $leagues,
            'breadcrumb' => [
                'Admin' => '/',
                'Organization' => '/admin/organization',
                $organization->name => "/organization/{$organization->id}",
                "Edit" => "/organization/{$organization->id}/edit"
            ]
        ]);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $organization = Organization::with(['addresses'])->find($id);
        if (empty($organization)) {
            return redirect()->back()->withErrors(['msg' => 'Could not find organization']);
        }

        $league_ot = OrganizationType::where('code', 'league')->first();
        $delete_league = false;
        if (request('organization_type_id') != $league_ot->id && $organization->organization_type_id == $league_ot->id) {
            // Confirm that league can be deleted
            $org_league_count = LeagueOrganization::where('league_id', $organization->league->id)->count();
            if ($org_league_count > 0) {
                $request->session()->flash('message', new Message(
                    "Sorry, this organization must remain a league while other organizations are filed under it.",
                    "danger",
                    $code = null,
                    $icon = "error"
                ));
                return back()->withInput();
            }
            $delete_league = true;
        }

        try {
            DB::transaction(function () use ($request, $organization, $league_ot, $delete_league) {
                $organization->name = request('name');
                $organization->parent_organization_id = request('parent_organization_id');
                $organization->organization_type_id = (int)request('organization_type_id');
                $organization->save();

                if ($request->organization_type_id == $league_ot->id) {
                    if (!$organization->league) {
                        // Create
                        $league = new League();
                        $league->abbreviation = request('abbreviation') ?: $organization->name;
                        $league->organization_id = $organization->id;
                        $league->save();
                    } else {
                        // Update
                        $organization->league->abbreviation = request('abbreviation') ?: $organization->name;
                        $organization->league->save();
                    }
                } else {
                    // Not a league
                    if (request('league_id') == '') {
                        $organization->leagues()->sync([]);
                    } else {
                        $league = League::where('id', request('league_id'))->first();
                        if ($league) {
                            $organization->leagues()->sync([$league->id]);
                        }
                    }
                }

                $address = $organization->addresses->first();

                if ($address) {
                    $address->name = request('name');
                    $address->line1 = request('line1');
                    $address->line2 = request('line2');
                    $address->city = request('city');
                    $address->state = request('state');
                    $address->postal_code = request('postal_code');
                    $address->country = request('country');
                    $address->save();
                } else {
                    if (request('line1') && request('city') && request('state') && request('postal_code') && request('country')) {
                        $address = new Address();
                        $address->name = request('name');
                        $address->line1 = request('line1');
                        $address->line2 = request('line2');
                        $address->city = request('city');
                        $address->state = request('state');
                        $address->postal_code = request('postal_code');
                        $address->country = request('country');
                        $address->save();

                        $organization->addresses()->attach($address);
                        $organization->save();
                    }
                }


                if ($image_file = request('image_url')) {
                    if ($organization->image) {
                        $image = ImageServiceProvider::saveFileAsImage(
                            $image_file,
                            $filename = UtilityServiceProvider::encode($organization->name).'-sports-business-solutions',
                            $directory = 'organization/'.$organization->id,
                            $options = ['update' => $organization->image]
                        );
                    } else {
                        $image = ImageServiceProvider::saveFileAsImage(
                            $image_file,
                            $filename = UtilityServiceProvider::encode($organization->name).'-sports-business-solutions',
                            $directory = 'organization/'.$organization->id,
                            $options = ['update' => $organization->image]
                        );

                        $organization->image()->associate($image);
                        $organization->save();
                    }
                }

                if ($delete_league) {
                    if ($league = $organization->league) {
                        // There are already no LeagueOrganizations (checked above)
                        // Just delete the League record
                        $league->delete();
                    }
                }
            });
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $request->session()->flash('message', new Message(
                "Sorry, we failed to update the organization. Please try again.",
                "danger",
                $code = null,
                $icon = "error"
            ));
            return back()->withInput();
        }

        return redirect()->action('OrganizationController@edit', [$organization]);
    }

    public function all()
    {
        if (Auth::user()) {
            return response()->json([
                'organizations' => OrganizationServiceProvider::all() ?: Organization::all(),
            ]);
        }
    }

    public function preview(Request $request, $id)
    {
        // $this->authorize('view-organization');

        $quality = request('quality') ?: null;

        $organization = Organization::find($id);

        $user = Auth::User();

        if(!is_null($organization->addresses->first())) {
            $city = $organization->addresses->first()->city;
            $state = $organization->addresses->first()->state;
            $country = $organization->addresses->first()->country;
        } else {
            $city = null;
            $state = null;
            $country = null;
        }

        return response()->json([
            'id' => $organization->id,
            'name' => $organization->name,
            'league' => $organization->leagues->count() > 0 ? $organization->leagues->first()->abbreviation : null,
            'address' => [
                'city' => $city,
                'state' => $state,
                'country' => $country,
            ],
            'image_url' => $organization->image ? $organization->image->getURL($quality) : null
        ]);
    }

    public function matchContacts($id)
    {
        $organization = Organization::find($id);
        if (empty($organization)) {
            return back();
        }

        $this->authorize('edit-organization', $organization);

        $count = 0;
        try {
            $count = OrganizationServiceProvider::mapContacts($organization);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }

        return response()->json([
            'id' => $organization->id,
            'name' => $organization->name,
            'count' => $count
        ]);
    }

    public function leagues()
    {
        $resp = [];
        $leagues = League::with('organization')->each(function ($league) use (&$resp) {
            $resp[] = [
                'id' => $league->id,
                'abbreviation' => $league->abbreviation,
                'name' => $league->organization->name,
                'organization_id' => $league->organization_id
            ];
        });

        return response()->json([
            'leagues' => $resp
        ]);
    }
}
