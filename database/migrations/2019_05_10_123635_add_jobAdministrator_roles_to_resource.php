<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJobAdministratorRolesToResource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // New role type
        DB::table('role')->insert(
            array(
                'code' => 'job_administrator',
                'description' => "Can manage and create jobs."
            )
        );

        // Job create
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_create',
                'role_code' => 'job_administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_edit',
                'role_code' => 'job_administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_delete',
                'role_code' => 'job_administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_index',
                'role_code' => 'job_administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_show',
                'role_code' => 'job_administrator'
            )
        );
        
        // Job featured
        DB::table('resource')->insert(
            array(
                'code' => 'job_featured',
                'description' => "Can enable a job to be featured."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_featured',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_featured',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_featured',
                'role_code' => 'moderator'
            )
        );

        // Recruiting type
        DB::table('resource')->insert(
            array(
                'code' => 'job_recruiting_type',
                'description' => "Can enable a job to be active or passive."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_recruiting_type',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_recruiting_type',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'job_recruiting_type',
                'role_code' => 'moderator'
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
        DB::delete('delete from role where code = job_administrator');
        DB::delete('delete from resource_role where resource_code = "job_featured"');
        DB::delete('delete from resource_role where resource_code = "job_recruiting_type"');
    }
}
