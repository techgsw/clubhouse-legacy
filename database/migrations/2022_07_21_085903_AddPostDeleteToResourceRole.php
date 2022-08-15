<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPostDeleteToResourceRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('resource_role')->insert(
            [
                'resource_code' => 'post_delete',
                'role_code' => 'administrator'
            ]
        );
        DB::table('resource_role')->insert(
            [
                'resource_code' => 'post_delete',
                'role_code' => 'superuser'
            ]
        );
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        DB::delete('delete from resource_role where resource_code = "post_delete"');
        Schema::enableForeignKeyConstraints();
    }
}
