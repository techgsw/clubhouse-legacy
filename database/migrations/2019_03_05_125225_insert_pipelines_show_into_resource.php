<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertPipelinesShowIntoResource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('resource')->insert(
            array(
                'code' => 'pipeline_show',
                'description' => 'Can view pipeline.'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'pipeline_edit',
                'description' => 'Can edit pipeline.'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'pipeline_create',
                'description' => 'Can create pipeline'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'administrator',
                'resource_code' => 'pipeline_show'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'superuser',
                'resource_code' => 'pipeline_show'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'administrator',
                'resource_code' => 'pipeline_edit'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'superuser',
                'resource_code' => 'pipeline_edit'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'administrator',
                'resource_code' => 'pipeline_create'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'superuser',
                'resource_code' => 'pipeline_create'
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
        DB::delete('delete from resource where code = "pipeline_edit"');
        DB::delete('delete from resource where code = "pipeline_create"');
        DB::delete('delete from resource where code = "pipeline_show  "');
        DB::delete('delete from resource_role where resource_code = "pipeline_show"');
        DB::delete('delete from resource_role where resource_code = "pipeline_edit"');
        DB::delete('delete from resource_role where resource_code = "pipeline_create"');

    }
}
