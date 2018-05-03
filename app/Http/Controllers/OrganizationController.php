<?php

namespace App\Http\Controllers;

use App\Image;
use App\Organization;
use App\Message;
use App\Providers\ImageServiceProvider;
use App\Providers\UtilityServiceProvider;
use App\Http\Requests\Organization\Store;
use App\Http\Requests\Organization\Update;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $organizations = Organization::with(['addresses', 'jobs'])
            ->search($request)
            ->orderBy('name', 'desc')
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

        return view('organization/create', [
            'breadcrumb' => [
                'Home' => '/admin',
                'Organization' => '/admin/organization',
                'Create' => '/organization/create'
            ]
        ]);
    }

    /**
     * @param  StoreOrganization  $request
     * @return Response
     */
    public function store(Store $request)
    {
        $organization = Organization::create([
            // TODO
        ]);

        if ($image_file = request()->file('image_url')) {
            try {
                $image = ImageServiceProvider::saveFileAsImage(
                    $image_file,
                    $filename = preg_replace('/\s/', '-', str_replace("/", "", $organization->name)).'-SportsBusinessSolutions',
                    $directory = 'organization/'.$organization->id
                );

                $organization->image_id = $image->id;
                $organization->save();
            } catch (Exception $e) {
                Log::error($e->getMessage());
                $request->session()->flash('message', new Message(
                    "Sorry, the file(s) failed to upload. Please try again.",
                    "danger",
                    $code = null,
                    $icon = "error"
                ));
                return back()->withInput();
            }
        }

        return redirect()->action('OrganizationController@show', [$organization]);
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
        $this->authorize('edit-organization');

        $organization = Organization::find($id);
        if (!$organization) {
            return redirect()->back()->withErrors(['msg' => 'Could not find organization']);
        }

        return view('organization/edit', [
            'organization' => $organization,
            'breadcrumb' => [
                'Admin' => '/',
                'Organization' => '/admin/organization',
                "Edit {$organization->name}" => "/organization/{$organization->id}/edit"
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

        $organization->name = request('name');
        $organization->parent_organization_id = request('parent_organization_id');
        $organization->save();

        $address = $organization->addresses->first();
        $address->line1 = request('line1');
        $address->line2 = request('line2');
        $address->city = request('city');
        $address->state = request('state');
        $address->postal_code = request('postal_code');
        $address->country = request('country');
        $address->save();

        if ($image_file = request('image_url')) {
            try {
                $image = ImageServiceProvider::saveFileAsImage(
                    $image_file,
                    $filename = UtilityServiceProvider::encode($organization->name).'-sports-business-solutions',
                    $directory = 'organization/'.$organization->id
                );

                if ($old_image = $organization->image) {
                    $organization->image()->dissociate($old_image);
                    $old_image->delete();
                }

                $organization->image()->associate($image);
                $organization->save();
            } catch (Exception $e) {
                Log::error($e->getMessage());
                $request->session()->flash('message', new Message(
                    "Sorry, the image failed to upload. Please try again.",
                    "danger",
                    $code = null,
                    $icon = "error"
                ));
                return back()->withInput();
            }
        }

        return redirect()->action('OrganizationController@edit', [$organization]);
    }

    public function all()
    {
        $this->authorize('view-organization');
        return response()->json([
            'organizations' => Organization::all()
        ]);
    }
}
