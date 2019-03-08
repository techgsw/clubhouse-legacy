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
                'code' => 'pipelines_show',
                'description' => 'Can view pipelines.'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'pipelines_edit',
                'description' => 'Can edit pipelines.'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'pipelines_create',
                'description' => 'Can create pipelines'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'administrator',
                'resource_code' => 'pipelines_show'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'superuser',
                'resource_code' => 'pipelines_show'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'administrator',
                'resource_code' => 'pipelines_edit'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'superuser',
                'resource_code' => 'pipelines_edit'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'administrator',
                'resource_code' => 'pipelines_create'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'role_code' => 'superuser',
                'resource_code' => 'pipelines_create'
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
        DB::delete('delete from resource where code = "pipelines_edit"');
        DB::delete('delete from resource where code = "pipelines_create"');
        DB::delete('delete from resource where code = "pipelines_show  "');
        DB::delete('delete from resource_role where resource_code = "pipelines_show"');
        DB::delete('delete from resource_role where resource_code = "pipelines_edit"');
        DB::delete('delete from resource_role where resource_code = "pipelines_create"');

    }
}
