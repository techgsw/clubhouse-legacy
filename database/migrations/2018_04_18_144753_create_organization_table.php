<?php

use App\Job;
use App\League;
use App\Organization;
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
            $league = new League([
                'name' => $name
            ]);
            $league->save();
            $league_to_id[$name] = $league->id;
        }

        Schema::create('organization', function (Blueprint $table) {
            $table->increments('id');
            // TODO $table->integer('image_id')->unsigned()->nullable()->default(null);
            // TODO $table->foreign('image_id')->references('id')->on('image');
            $table->string('name');
            $table->string('city');
            $table->string('state');
            $table->string('country');
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

        Schema::create('job_organization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')->references('id')->on('job');
            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organization');
            $table->timestamps();
        });

        $organizations = [
            "Brooklyn Sports & Entertainment" => [
                "id" => null,
                "city" => "Brooklyn",
                "state" => "NY",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Chicago Cubs" => [
                "id" => null,
                "city" => "Chicago",
                "state" => "IL",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "Marquee Sports & Entertainment" => [
                "id" => null,
                "city" => "Chicago",
                "state" => "IL",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "Cincinnati Bengals" => [
                "id" => null,
                "city" => "Cincinnati",
                "state" => "OH",
                "country" => "US",
                "leagues" => ["NFL"]
            ],
            "Cleveland Cavaliers" => [
                "id" => null,
                "city" => "Cleveland",
                "state" => "OH",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Connecticut Sun" => [
                "id" => null,
                "city" => "Hartford",
                "state" => "CT",
                "country" => "US",
                "leagues" => ["WNBA"]
            ],
            "New England Black Wolves" => [
                "id" => null,
                "city" => "Uncasville",
                "state" => "CT",
                "country" => "US",
                "leagues" => ["NLL"]
            ],
            "Dallas Stars" => [
                "id" => null,
                "city" => "Dallas",
                "state" => "TX",
                "country" => "US",
                "leagues" => ["NHL"]
            ],
            "Denver Nuggets" => [
                "id" => null,
                "city" => "Denver",
                "state" => "CO",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Detroit Pistons" => [
                "id" => null,
                "city" => "Detroit",
                "state" => "MI",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Eventia Sports & Entertainment Group" => [
                "id" => null,
                "city" => "Las Vegas",
                "state" => "NV",
                "country" => "US",
                "leagues" => []
            ],
            "FC Dallas" => [
                "id" => null,
                "city" => "Frisco",
                "state" => "TX",
                "country" => "US",
                "leagues" => ["MLS"]
            ],
            "Florida Panthers" => [
                "id" => null,
                "city" => "Sunrise",
                "state" => "FL",
                "country" => "US",
                "leagues" => ["NHL"]
            ],
            "Florida Tarpons" => [
                "id" => null,
                "city" => "Lakeland",
                "state" => "FL",
                "country" => "US",
                "leagues" => ["AFL"]
            ],
            "Grabyo" => [
                "id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => []
            ],
            "Los Angeles Rams" => [
                "id" => null,
                "city" => "Agoura Hills",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["NFL"]
            ],
            "Lake Erie Crushers" => [
                "id" => null,
                "city" => "Lake Erie",
                "state" => "OH",
                "country" => "US",
                "leagues" => ["Frontier League"]
            ],
            "Legends Global Sales - One World Observatory" => [
                "id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => []
            ],
            "Living Sport" => [
                "id" => null,
                "city" => "Dublin",
                "state" => "Northern Ireland",
                "country" => "UK",
                "leagues" => []
            ],
            "Long Island Ducks" => [
                "id" => null,
                "city" => "Central Islip",
                "state" => "NY",
                "country" => "US",
                "leagues" => ["Atlantic League"]
            ],
            "New Jersey Devils" => [
                "id" => null,
                "city" => "Camden",
                "state" => "NJ",
                "country" => "US",
                "leagues" => ["NHL"]
            ],
            "New York Jets" => [
                "id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => ["NFL"]
            ],
            "New York Mets" => [
                "id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "New York Yankees" => [
                "id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "Norfolk Admirals" => [
                "id" => null,
                "city" => "Norfolk",
                "state" => "VA",
                "country" => "US",
                "leagues" => ["ECHL"]
            ],
            "Oakland Athletics" => [
                "id" => null,
                "city" => "Oakland",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "Oilers Entertainment Group" => [
                "id" => null,
                "city" => "Edmonton",
                "state" => "AB",
                "country" => "CA",
                "leagues" => ["NHL"]
            ],
            "Omnigon" => [
                "id" => null,
                "city" => "New York",
                "state" => "NY",
                "country" => "US",
                "leagues" => []
            ],
            "Orange County Soccer Club" => [
                "id" => null,
                "city" => "Irvine",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["USL"]
            ],
            "Orlando Magic" => [
                "id" => null,
                "city" => "Orlando",
                "state" => "FL",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Phoenix Suns" => [
                "id" => null,
                "city" => "Phoenix",
                "state" => "AZ",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Phoenix Mercury" => [
                "id" => null,
                "city" => "Phoenix",
                "state" => "AZ",
                "country" => "US",
                "leagues" => ["WNBA"]
            ],
            "Portland Timbers" => [
                "id" => null,
                "city" => "Portland",
                "state" => "OR",
                "country" => "US",
                "leagues" => ["MLS"]
            ],
            "Sacramento Kings" => [
                "id" => null,
                "city" => "Sacramento",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Sacramento Republic FC" => [
                "id" => null,
                "city" => "Sacramento",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["USL"]
            ],
            "San Francisco 49ers" => [
                "id" => null,
                "city" => "Santa Clara",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["NFL"]
            ],
            "San Jose Sharks" => [
                "id" => null,
                "city" => "San Jose",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["NHL"]
            ],
            "San Jose Earthquakes" => [
                "id" => null,
                "city" => "San Jose",
                "state" => "CA",
                "country" => "US",
                "leagues" => ["MLS"]
            ],
            "Sports Business Solutions" => [
                "id" => null,
                "city" => "Phoenix",
                "state" => "AZ",
                "country" => "US",
                "leagues" => []
            ],
            "Tampa Bay Sports & Entertainment" => [
                "id" => null,
                "city" => "Tampa",
                "state" => "FL",
                "country" => "US",
                "leagues" => ["NHL"]
            ],
            "Tampa Bay Rays" => [
                "id" => null,
                "city" => "St. Petersburg",
                "state" => "FL",
                "country" => "US",
                "leagues" => ["MLB"]
            ],
            "Tough Mudder HQ" => [
                "id" => null,
                "city" => "Brooklyn",
                "state" => "NY",
                "country" => "US",
                "leagues" => []
            ],
            "Viwa Ticket Management Solutions" => [
                "id" => null,
                "city" => "Scottsdale",
                "state" => "AZ",
                "country" => "US",
                "leagues" => []
            ],
            "Wizards District Gaming" => [
                "id" => null,
                "city" => "Washington",
                "state" => "DC",
                "country" => "US",
                "leagues" => ["NBA"]
            ],
            "Monumental Sports & Entertainment" => [
                "id" => null,
                "city" => "Washington",
                "state" => "DC",
                "country" => "US",
                "leagues" => ["NHL", "NBA", "WNBA", "AFL"]
            ],
        ];

        foreach ($organizations as $name => $fields) {
            $organization = new Organization([
                'name' => $name,
                'city' => $fields['city'],
                'state' => $fields['state'],
                'country' => $fields['country']
            ]);
            $organization->save();

            $organizations[$name]['id'] = $organization->id;

            $league_ids = [];
            foreach ($fields['leagues'] as $league_name) {
                $league_ids[] = $league_to_id[$league_name];
            }
            $organization->leagues()->attach($league_ids);
            $organization->save();
        }

        $job_to_organizations = [
            "Brooklyn Nets (BSE)" => ["Brooklyn Sports & Entertainment"],
            "Brooklyn Sports & Entertainment" => ["Brooklyn Sports & Entertainment"],
            "Brooklyn Sports & Entertainment (NBA)" => ["Brooklyn Sports & Entertainment"],
            "Chicago Cubs - Marquee Sports & Entertainment (MLB)" => ["Chicago Cubs", "Marquee Sports & Entertainment"],
            "Chicago Cubs // Marquee Sports & Entertainment" => ["Chicago Cubs", "Marquee Sports & Entertainment"],
            "Marquee Sports & Entertainment // Chicago Cubs (MLB)" => ["Chicago Cubs", "Marquee Sports & Entertainment"],
            "Cincinnati Bengals (NFL)" => ["Cincinnati Bengals"],
            "Cleveland Cavaliers" => ["Cleveland Cavaliers"],
            "Connecticut Sun (WNBA) & New England Black Wolves (NLL)" => ["Connecticut Sun", "New England Black Wolves"],
            "Connecticut Sun / New England Black Wolves" => ["Connecticut Sun", "New England Black Wolves"],
            "Dallas Stars (NHL)" => ["Dallas Stars"],
            "Denver Nuggets (NBA)" => ["Denver Nuggets"],
            "Detroit Pistons (NBA)" => ["Detroit Pistons"],
            "Eventia Sports & Entertainment Group" => ["Eventia Sports & Entertainment Group"],
            "FC Dallas (MLS)" => ["FC Dallas"],
            "Florida Panthers (NHL)" => ["Florida Panthers"],
            "Florida Tarpons (AFL)" => ["Florida Tarpons"],
            "Grabyo" => ["Grabyo"],
            "LA Rams (NFL)" => ["Los Angeles Rams"],
            "Lake Erie Crushers" => ["Lake Erie Crushers"],
            "Legends Global Sales - One World Observatory" => ["Legends Global Sales - One World Observatory"],
            "Living Sport" => ["Living Sport"],
            "Long Island Ducks (Atlantic League)" => ["Long Island Ducks"],
            "New Jersey Devils (NHL)" => ["New Jersey Devils"],
            "New York Jets (NFL)" => ["New York Jets"],
            "NY Jets (NFL)" => ["New York Jets"],
            "New York Mets" => ["New York Mets"],
            "New York Yankees (MLB)" => ["New York Yankees"],
            "Norfolk Admirals" => ["Norfolk Admirals"],
            "Oakland Athletics" => ["Oakland Athletics"],
            "Oakland Athletics (MLB)" => ["Oakland Athletics"],
            "Oilers Entertainment Group (Edmonton, CAN)" => ["Oilers Entertainment Group"],
            "Omnigon" => ["Omnigon"],
            "Orange County Soccer Club (USL)" => ["Orange County Soccer Club"],
            "Orlando Magic (NBA)" => ["Orlando Magic"],
            "Phoenix Suns, Mercury, Talking Stick Resort Arena" => ["Phoenix Suns", "Phoenix Mercury"],
            "Portland Timbers" => ["Portland Timbers"],
            "Sacramento Kings" => ["Sacramento Kings"],
            "Sacramento Republic FC (USL)" => ["Sacramento Republic FC"],
            "San Francisco 49ers" => ["San Francisco 49ers"],
            "San Francisco 49ers (NFL)" => ["San Francisco 49ers"],
            "San Jose Sharks" => ["San Jose Sharks"],
            "San Jose Sharks (NHL)" => ["San Jose Sharks"],
            "SJ Earthquakes (MLS)" => ["San Jose Earthquakes"],
            "Sports Business Solutions" => ["Sports Business Solutions"],
            "Sports Business Solutions, LLC" => ["Sports Business Solutions"],
            "Tampa Bay Lightning" => ["Tampa Bay Sports & Entertainment"],
            "Tampa Bay Sports & Entertainment (NHL)" => ["Tampa Bay Sports & Entertainment"],
            "Tampa Bay Rays (MLB)" => ["Tampa Bay Rays"],
            "Tough Mudder HQ" => ["Tough Mudder HQ"],
            "Viwa Ticket Management Solutions" => ["Viwa Ticket Management Solutions"],
            "Wizards District Gaming // Monumental Sports & Entertainment" => ["Wizards District Gaming", "Monumental Sports & Entertainment"]
        ];

        Job::all()->each(function ($job) use ($job_to_organizations, $organizations) {
            $organization_ids = [];
            foreach ($job_to_organizations[$job->organization] as $name) {
                $organization_ids[] = $organizations[$name]['id'];
            }
            $job->organizations()->attach($organization_ids);
            $job->save();
        });

        Schema::create('address_organization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')->references('id')->on('address');
            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organization');
            $table->timestamps();
        });

        Schema::create('contact_organization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('contact');
            $table->integer('organization_id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('organization');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
