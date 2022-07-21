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
        DB::table('resource_role')->insert(
            [
                'resource_code' => 'post_delete',
                'role_code' => 'adminstator'
            ]
        );
        DB::table('resource_role')->insert(
            [
                'resource_code' => 'post_delete',
                'role_code' => 'superuser'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('delete from resource_role where resource_code = "post_delete"');
    }
}
