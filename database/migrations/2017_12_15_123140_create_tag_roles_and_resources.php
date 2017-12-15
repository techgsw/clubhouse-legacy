<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagRolesAndResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create Tag
        DB::table('resource')->insert(
            array(
                'code' => 'tag_create',
                'description' => "Can create a tag."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'tag_create',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'tag_create',
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
        DB::delete('delete from resource_role where resource_code = "tag_create"');
        DB::delete('delete from resource where code = "tag_create"');
    }
}
