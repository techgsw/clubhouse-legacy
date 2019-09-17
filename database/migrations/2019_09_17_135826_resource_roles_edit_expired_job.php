<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResourceRolesEditExpiredJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('resource')->insert(
            array (
                'code' => 'job_edit_expired',
                'description' => 'Can edit expired jobs.'
            )
        );

        DB::table('resource_role')->insert(
            array(
                array(
                    'resource_code' => 'job_edit_expired',
                    'role_code' => 'administrator'
                ),
                array(
                    'resource_code' => 'job_edit_expired',
                    'role_code' => 'superuser'
                )
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
        DB::delete('delete from resource_role where resource_code = "job_edit_expired"');
        DB::delete('delete from resource where code = "job_edit_expired"');
    }
}
