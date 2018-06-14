<?php

use App\Address;
use App\Image;
use App\Job;
use App\League;
use App\Organization;
use App\Providers\ImageServiceProvider;
use App\Providers\UtilityServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('league', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->timestamps();
        });

        $league_to_id = [
            "MLB" => null,
            "MLS" => null,
            "NBA" => null,
            "NFL" => null,
            "NHL" => null,
            "WNBA" => null,
            "NLL" => null,
            "AFL" => null,
            "Atlantic League" => null,
            "ECHL" => null,
            "USL" => null,
            "Frontier League" => null
        ];

        foreach ($league_to_id as $name => $id) {
            $code = UtilityServiceProvider::encode($name);
            $league = new League([
                'name' => $name,
                'code' => $code
            ]);
            $league->save();
            $league_to_id[$name] = $league->id;
        }

        Schema::create('organization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('image_id')->unsigned()->nullable()->default(null);
            $table->foreign('image_id')->references('id')->on('image');
            $table->integer('parent_organization_id')->unsigned()->nullable()->default(null);
            $table->foreign('parent_organization_id')->references('id')->on('organization');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('address_organization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')->references('id')->on('address');
            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organization');
            $table->timestamps();
        });

        Schema::create('league_organization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('league_id')->unsigned();
            $table->foreign('league_id')->references('id')->on('league');
            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organization');
            $table->timestamps();
        });

        Schema::table('job', function (Blueprint $table) {
            $table->integer('organization_id')->unsigned()->after('organization')->nullable()->default(null);
            $table->foreign('organization_id')->references('id')->on('organization');
        });

        $parent_organizations = [
            "Marquee Sports & Entertainment" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Chicago",
                "state" => "IL",
                "country" => "US",
                "leagues" => []
            ],
            "Mohegan" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Uncasville",
                "state" => "CT",
                "country" => "US",
                "leagues" => []
            ],
            "Monumental Sports & Entertainment" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Washington",
                "state" => "DC",
                "country" => "US",
                "leagues" => []
            ],
            "Phoenix Suns Legacy Partners" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Phoenix",
                "state" => "AZ",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
        ];

        foreach ($parent_organizations as $name => $fields) {
            $organization = new Organization([
                'name' => $name
            ]);
            $organization->save();

            $address = new Address([
                'name' => $name,
                'city' => $fields['city'],
                'state' => $fields['state'],
                'country' => $fields['country']
            ]);
            $address->save();
            $organization->addresses()->attach($address->id);

            $league_ids = [];
            foreach ($fields['leagues'] as $league_name) {
                $league_ids[] = $league_to_id[$league_name];
            }
            $organization->leagues()->attach($league_ids);
            $organization->save();

            $parent_organizations[$name] = $organization;
        }

        $organizations = [
            "Atlanta Hawks" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Atlanta",
                "state" => "GA",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Brooklyn Sports & Entertainment" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Brooklyn",
                "state" => "NY",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Chicago Cubs" => [
                "id" => null,
                "parent_organization_id" => $parent_organizations["Marquee Sports & Entertainment"]["id"],
                "city" => "Chicago",
                "state" => "IL",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "Cincinnati Bengals" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Cincinnati",
                "state" => "OH",
                "country" => "US",
                "leagues" => ["NFL"]
            ],
            "Cleveland Cavaliers" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Cleveland",
                "state" => "OH",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Connecticut Sun" => [
                "id" => null,
                "parent_organization_id" => $parent_organizations["Mohegan"]["id"],
                "city" => "Hartford",
                "state" => "CT",
                "country" => "US",
                "leagues" => ["WNBA"]
            ],
            "New England Black Wolves" => [
                "id" => null,
                "parent_organization_id" => $parent_organizations["Mohegan"]["id"],
                "city" => "Uncasville",
                "state" => "CT",
                "country" => "US",
                "leagues" => ["NLL"]
            ],
            "Dallas Stars" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Dallas",
                "state" => "TX",
                "country" => "US",
                "leagues" => ["NHL"]
            ],
            "Denver Nuggets" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Denver",
                "state" => "CO",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Detroit Pistons" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Detroit",
                "state" => "MI",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Eventia Sports & Entertainment Group" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Las Vegas",
                "state" => "NV",
                "country" => "US",
                "leagues" => []
            ],
            "FC Dallas" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Frisco",
                "state" => "TX",
                "country" => "US",
                "leagues" => ["MLS"]
            ],
            "Florida Panthers" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Sunrise",
                "state" => "FL",
                "country" => "US",
                "leagues" => ["NHL"]
            ],
            "Florida Tarpons" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Lakeland",
                "state" => "FL",
                "country" => "US",
                "leagues" => ["AFL"]
            ],
            "Grabyo" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => []
            ],
            "International Speedway Corporation" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Daytona Beach",
                "state" => "FL",
                "country" => "US",
                "leagues" => []
            ],
            "Los Angeles Rams" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Agoura Hills",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["NFL"]
            ],
            "Lake Erie Crushers" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Lake Erie",
                "state" => "OH",
                "country" => "US",
                "leagues" => ["Frontier League"]
            ],
            "Legends Global Sales" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => []
            ],
            "Living Sport" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Dublin",
                "state" => "Northern Ireland",
                "country" => "UK",
                "leagues" => []
            ],
            "Long Island Ducks" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Central Islip",
                "state" => "NY",
                "country" => "US",
                "leagues" => ["Atlantic League"]
            ],
            "New Jersey Devils" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Camden",
                "state" => "NJ",
                "country" => "US",
                "leagues" => ["NHL"]
            ],
            "New York Jets" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => ["NFL"]
            ],
            "New York Mets" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "New York Yankees" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "Norfolk Admirals" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Norfolk",
                "state" => "VA",
                "country" => "US",
                "leagues" => ["ECHL"]
            ],
            "Oakland Athletics" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Oakland",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "Oilers Entertainment Group" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Edmonton",
                "state" => "AB",
                "country" => "CA",
                "leagues" => ["NHL"]
            ],
            "Omnigon" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => []
            ],
            "Orange County Soccer Club" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Irvine",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["USL"]
            ],
            "Orlando Magic" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Orlando",
                "state" => "FL",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Phoenix Mercury" => [
                "id" => null,
                "parent_organization_id" => $parent_organizations["Phoenix Suns Legacy Partners"]["id"],
                "city" => "Phoenix",
                "state" => "AZ",
                "country" => "US",
                "leagues" => ["WNBA"]
            ],
            "Phoenix Suns" => [
                "id" => null,
                "parent_organization_id" => $parent_organizations["Phoenix Suns Legacy Partners"]["id"],
                "city" => "Phoenix",
                "state" => "AZ",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Portland Timbers" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Portland",
                "state" => "OR",
                "country" => "US",
                "leagues" => ["MLS"]
            ],
            "Sacramento Kings" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Sacramento",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Sacramento Republic FC" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Sacramento",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["USL"]
            ],
            "San Francisco 49ers" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Santa Clara",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["NFL"]
            ],
            "San Jose Sharks" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "San Jose",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["NHL"]
            ],
            "San Jose Earthquakes" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "San Jose",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["MLS"]
            ],
            "Sports Business Solutions" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Phoenix",
                "state" => "AZ",
                "country" => "US",
                "leagues" => []
            ],
            "Tampa Bay Sports & Entertainment" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Tampa",
                "state" => "FL",
                "country" => "US",
                "leagues" => ["NHL"]
            ],
            "Tampa Bay Rays" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "St. Petersburg",
                "state" => "FL",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "Tough Mudder HQ" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Brooklyn",
                "state" => "NY",
                "country" => "US",
                "leagues" => []
            ],
            "viagogo" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => []
            ],
            "Viwa Ticket Management Solutions" => [
                "id" => null,
                "parent_organization_id" => null,
                "city" => "Scottsdale",
                "state" => "AZ",
                "country" => "US",
                "leagues" => []
            ],
            "Wizards District Gaming" => [
                "id" => null,
                "parent_organization_id" => $parent_organizations["Monumental Sports & Entertainment"]["id"],
                "city" => "Washington",
                "state" => "DC",
                "country" => "US",
                "leagues" => []
            ],
        ];

        foreach ($organizations as $name => $fields) {
            $organization = new Organization([
                'name' => $name
            ]);
            $organization->save();

            $address = new Address([
                'name' => $name,
                'city' => $fields['city'],
                'state' => $fields['state'],
                'country' => $fields['country']
            ]);
            $address->save();
            $organization->addresses()->attach($address->id);

            $league_ids = [];
            foreach ($fields['leagues'] as $league_name) {
                $league_ids[] = $league_to_id[$league_name];
            }
            $organization->leagues()->attach($league_ids);
            $organization->save();

            // Replace associative array of fields with actual organization instance
            $organizations[$name] = $organization;
        }

        // Add parent organizations to organization list
        foreach ($parent_organizations as $org) {
            $organizations[$org->name] = $org;
        }

        $job_to_organization = [
            "Atlanta Hawks" => "Atlanta Hawks",
            "Brooklyn Nets (BSE)" => "Brooklyn Sports & Entertainment",
            "Brooklyn Sports & Entertainment" => "Brooklyn Sports & Entertainment",
            "Brooklyn Sports & Entertainment (NBA)" => "Brooklyn Sports & Entertainment",
            "Chicago Cubs" => "Chicago Cubs",
            "Chicago Cubs - Marquee Sports & Entertainment (MLB)" => "Marquee Sports & Entertainment",
            "Chicago Cubs // Marquee Sports & Entertainment" => "Marquee Sports & Entertainment",
            "Marquee Sports & Entertainment // Chicago Cubs (MLB)" => "Marquee Sports & Entertainment",
            "Cincinnati Bengals (NFL)" => "Cincinnati Bengals",
            "Cleveland Cavaliers" => "Cleveland Cavaliers",
            "Connecticut Sun (WNBA) & New England Black Wolves (NLL)" => "Mohegan",
            "Connecticut Sun / New England Black Wolves" => "Mohegan",
            "Dallas Stars (NHL)" => "Dallas Stars",
            "Denver Nuggets (NBA)" => "Denver Nuggets",
            "Detroit Pistons (NBA)" => "Detroit Pistons",
            "Eventia Sports & Entertainment Group" => "Eventia Sports & Entertainment Group",
            "FC Dallas (MLS)" => "FC Dallas",
            "Florida Panthers (NHL)" => "Florida Panthers",
            "Florida Panthers" => "Florida Panthers",
            "Florida Tarpons (AFL)" => "Florida Tarpons",
            "Grabyo" => "Grabyo",
            "International Speedway Corporation" => "International Speedway Corporation",
            "LA Rams (NFL)" => "Los Angeles Rams",
            "Lake Erie Crushers" => "Lake Erie Crushers",
            "Legends Global Sales - One World Observatory" => "Legends Global Sales",
            "Legends Global Sales" => "Legends Global Sales",
            "Living Sport" => "Living Sport",
            "Long Island Ducks (Atlantic League)" => "Long Island Ducks",
            "New Jersey Devils (NHL)" => "New Jersey Devils",
            "New Jersey Devils" => "New Jersey Devils",
            "New York Jets (NFL)" => "New York Jets",
            "NY Jets (NFL)" => "New York Jets",
            "New York Mets" => "New York Mets",
            "New York Yankees (MLB)" => "New York Yankees",
            "Norfolk Admirals" => "Norfolk Admirals",
            "Oakland Athletics" => "Oakland Athletics",
            "Oakland Athletics (MLB)" => "Oakland Athletics",
            "Oilers Entertainment Group (Edmonton, CAN)" => "Oilers Entertainment Group",
            "Omnigon" => "Omnigon",
            "Orange County Soccer Club (USL)" => "Orange County Soccer Club",
            "Orlando Magic (NBA)" => "Orlando Magic",
            "Phoenix Suns, Mercury, Talking Stick Resort Arena" => "Phoenix Suns",
            "Portland Timbers" => "Portland Timbers",
            "Sacramento Kings" => "Sacramento Kings",
            "Sacramento Republic FC (USL)" => "Sacramento Republic FC",
            "Sacramento Republic FC" => "Sacramento Republic FC",
            "San Francisco 49ers" => "San Francisco 49ers",
            "San Francisco 49ers (NFL)" => "San Francisco 49ers",
            "San Jose Sharks" => "San Jose Sharks",
            "San Jose Sharks (NHL)" => "San Jose Sharks",
            "SJ Earthquakes (MLS)" => "San Jose Earthquakes",
            "Sports Business Solutions" => "Sports Business Solutions",
            "Sports Business Solutions, LLC" => "Sports Business Solutions",
            "Tampa Bay Lightning" => "Tampa Bay Sports & Entertainment",
            "Tampa Bay Sports & Entertainment (NHL)" => "Tampa Bay Sports & Entertainment",
            "Tampa Bay Rays (MLB)" => "Tampa Bay Rays",
            "Tough Mudder HQ" => "Tough Mudder HQ",
            "viagogo" => "viagogo",
            "Viwa Ticket Management Solutions" => "Viwa Ticket Management Solutions",
            "Wizards District Gaming // Monumental Sports & Entertainment" => "Wizards District Gaming",
        ];

        Job::all()->each(function ($job) use ($job_to_organization, $organizations) {
            if (!array_key_exists($job->organization, $job_to_organization)) {
                dump("Unhandled organization: {$job->organization}");
                return;
            }
            $organization_name = $job_to_organization[$job->organization];
            $organization = $organizations[$organization_name];
            $job->organization_id = $organization->id;
            $job->save();

            if ($job->image && !$organization->image_id) {
                $image = ImageServiceProvider::clone(
                    $job->image,
                    $filename = preg_replace('/\s/', '-', str_replace("/", "", $organization->name)).'-SportsBusinessSolutions',
                    "organization/{$organization->id}"
                );
                $organization->image_id = $image->id;
                $organization->save();
            }
        });

        Schema::create('contact_organization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('contact');
            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organization');
            $table->timestamps();
        });

        DB::table('resource')->insert(
            array(
                'code' => 'admin_organization',
                'description' => "Can administrate any organization."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'admin_organization',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'admin_organization',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'organization_show',
                'description' => "Can view any organization."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'organization_show',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'organization_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'organization_create',
                'description' => "Can create an organization."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'organization_create',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'organization_create',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'organization_edit',
                'description' => "Can edit any organization."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'organization_edit',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'organization_edit',
                'role_code' => 'administrator'
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('resource_role')->where('resource_code', 'admin_organization')->delete();
        DB::table('resource')->where('code', 'admin_organization')->delete();
        DB::table('resource_role')->where('resource_code', 'organization_edit')->delete();
        DB::table('resource')->where('code', 'organization_edit')->delete();
        DB::table('resource_role')->where('resource_code', 'organization_create')->delete();
        DB::table('resource')->where('code', 'organization_create')->delete();
        DB::table('resource_role')->where('resource_code', 'organization_show')->delete();
        DB::table('resource')->where('code', 'organization_show')->delete();
        Schema::dropIfExists('contact_organization');
        Schema::dropIfExists('address_organization');
        Schema::dropIfExists('league_organization');
        Schema::table('job', function (Blueprint $table) {
            $table->dropForeign('organization_id');
            $table->dropColumn('organization_id');
        });
        Schema::dropIfExists('organization');
        Schema::dropIfExists('league');
    }
}
