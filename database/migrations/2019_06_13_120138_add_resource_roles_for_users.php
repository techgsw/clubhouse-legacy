<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddResourceRolesForUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_create',
                'role_code' => 'job_user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_create',
                'role_code' => 'job_user_plus'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_create',
                'role_code' => 'job_user_premium'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_edit',
                'role_code' => 'job_user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_edit',
                'role_code' => 'job_user_plus'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_edit',
                'role_code' => 'job_user_premium'
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
    }
}
