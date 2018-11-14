<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClubhouseResource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('resource')->insert(
            array(
                'code' => 'clubhouse_view',
                'description' => "Can access clubhouse related content."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'clubhouse_view',
                'role_code' => 'clubhouse'
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
        DB::table('resource_role')->where('resource_code', 'clubhouse_view')->delete();
        DB::table('resource')->where('code', 'clubhouse_view')->delete();
    }
}
