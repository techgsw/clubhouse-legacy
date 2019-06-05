<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleCodesForJobAdministrators extends Migration
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
                'resource_code' => 'organization_show',
                'role_code' => 'job_administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'organization_create',
                'role_code' => 'job_administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'organization_edit',
                'role_code' => 'job_administrator'
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
        DB::delete('delete from resource_role where resource_code = "organization_show" and role_code="job_administrator"');
        DB::delete('delete from resource_role where resource_code = "organization_create" and role_code="job_administrator"');
        DB::delete('delete from resource_role where resource_code = "organization_edit" and role_code="job_administrator"');

    }
}
