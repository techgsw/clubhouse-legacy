<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSessionPostTypeRolesAndResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create Post
        DB::table('resource')->insert(
            array(
                'code' => 'post_session_create',
                'description' => "Can create a session post."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_session_create',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_session_create',
                'role_code' => 'superuser'
            )
        );
        // Edit Post
        DB::table('resource')->insert(
            array(
                'code' => 'post_session_edit',
                'description' => "Can edit a session post."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_session_edit',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_session_edit',
                'role_code' => 'superuser'
            )
        );
        // View Post (not going to use, currently)
        DB::table('resource')->insert(
            array(
                'code' => 'post_session_show',
                'description' => "Can view a session post."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_session_show',
                'role_code' => 'user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_session_show',
                'role_code' => 'moderator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_session_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_session_show',
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
        DB::delete('delete from resource_role where resource_code = "post_session_create"');
        DB::delete('delete from resource_role where resource_code = "post_session_edit"');
        DB::delete('delete from resource where code = "post_session_create"');
        DB::delete('delete from resource where code = "post_session_edit"');
        DB::delete('delete from resource where code = "post_session_show"');
    }
}
