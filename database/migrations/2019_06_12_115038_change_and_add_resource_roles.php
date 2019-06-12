<?php

use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAndAddResourceRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // job_user, job_user_plus, job_user_premium lets go with the about as roles 
        // resources can be, job_listing, job_listing_plus and job_listing_premium
        DB::table('role')->where('code', '=', 'Free')->delete();
        DB::table('role')->where('code', '=', 'Tier 1')->delete();
        DB::table('role')->where('code', '=', 'Tier 2')->delete();

        

        DB::table('role')->insert(
            array (
                'code' => 'job_user',
                'description' => 'Job User is currently free for 30 days, or until filled.'
            )
        );

        DB::table('role')->insert(
            array (
                'code' => 'job_user_plus',
                'description' => 'Job User Premium is currently priced at $250 for 60 days, or until filled.'
            )
        );
        DB::table('role')->insert(
            array (
                'code' => 'job_user_premium',
                'description' => 'Job User Premium is currently priced at $500 for 90 days, or until filled.'
            )
        );
        DB::table('resource')->insert(
            array (
                'code' => 'job_listing',
                'description' => 'Has the ability to view job listings, and get general marketing from the job board.'
            )
        );
        DB::table('resource')->insert(
            array (
                'code' => 'job_listing_plus',
                'description' => 'Has the ability to view job listings, edit job listings, get external promotion, and will be featured.'
            )
        );
        DB::table('resource')->insert(
            array (
                'code' => 'job_listing_premium',
                'description' => 'Has the ability to view job listings, edit job listings, get promotionals, SBS recruiter involvment, and will be top featured as well as marketed.'
            )
        );

        $users = User::all();

        foreach ($users as $user) {
            DB::table('role_user')->insert(
                array (
                    'user_id' => $user->id,
                    'role_code' => 'job_user'
                )
            );
        }
        DB::table('resource_role')->insert(
            array (
                'role_code' => 'user',
                'resource_code' => 'job_listing'
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
        //
        DB::table('role')->where('code', '=', 'job_user')->delete();
        DB::table('role')->where('code', '=', 'job_user_plus')->delete();
        DB::table('role')->where('code', '=', 'job_user_premium')->delete();
        DB::table('resource')->where('code', '=', 'job_listing')->delete();
        DB::table('resource')->where('code', '=', 'job_listing_plus')->delete();
        DB::table('resource')->where('code', '=', 'job_listing_premium')->delete();
        DB::table('resource_role')->where('resource_code', '=', 'job_listing')->delete();
        DB::table('role_user')->where('role_code', '=', 'job_user')->delete();

    }
}
