<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactDeleteRole extends Migration
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
                'code' => 'delete_contacts',
                'description' => 'Can delete contacts from the system.'
            )
        );

        DB::table('resource_role')->insert(
            array(
                array(
                    'resource_code' => 'delete_contacts',
                    'role_code' => 'administrator'
                ),
                array(
                    'resource_code' => 'delete_contacts',
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
        DB::delete('delete from resource_role where resource_code = "delete_contacts"');
        DB::delete('delete from resource where code = "delete_contacts"');
    }
}
