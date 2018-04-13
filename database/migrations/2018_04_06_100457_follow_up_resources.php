<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FollowUpResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('resource')->insert(
            array(
                'code' => 'follow_up',
                'description' => "Can schedule and complete a follow up with a contact."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'follow_up',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'follow_up',
                'role_code' => 'superuser'
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
        DB::table('resource_role')->where('resource_code', 'follow_up')->delete();
        DB::table('resource')->where('code', 'follow_up')->delete();
    }
}
