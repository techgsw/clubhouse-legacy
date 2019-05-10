<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRolesToResource extends Migration
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
                'code' => 'edit_roles',
                'description' => "Can edit user roles."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'edit_roles',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'edit_roles',
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
        DB::delete('delete from resource_role where resource_code = "edit_roles"');
        DB::delete('delete from resource where code = "edit_roles"');
    }
}
