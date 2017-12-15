<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogRolesAndResources extends Migration
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
                'code' => 'post_create',
                'description' => "Can create a blog post."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_create',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_create',
                'role_code' => 'superuser'
            )
        );
        // Edit Post
        DB::table('resource')->insert(
            array(
                'code' => 'post_edit',
                'description' => "Can edit a blog post."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_edit',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_edit',
                'role_code' => 'superuser'
            )
        );
        // View Post (not going to use, currently)
        DB::table('resource')->insert(
            array(
                'code' => 'post_show',
                'description' => "Can view a blog post."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_show',
                'role_code' => 'user'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_show',
                'role_code' => 'moderator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'post_show',
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
        DB::delete('delete from resource_role where resource_code = "post_create"');
        DB::delete('delete from resource_role where resource_code = "post_edit"');
        DB::delete('delete from resource where code = "post_create"');
        DB::delete('delete from resource where code = "post_edit"');
        DB::delete('delete from resource where code = "post_show"');
    }
}
