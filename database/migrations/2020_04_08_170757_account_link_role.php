<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccountLinkRole extends Migration
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
                'code' => 'account_link',
                'description' => 'Can link user accounts and view account links.'
            )
        );

        DB::table('resource_role')->insert(
            array(
                array(
                    'resource_code' => 'account_link',
                    'role_code' => 'administrator'
                ),
                array(
                    'resource_code' => 'account_link',
                    'role_code' => 'superuser'
                )
            )
        );    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::delete('delete from resource_role where resource_code = "account_link"');
        DB::delete('delete from resource where code = "account_link"');
    }
}
