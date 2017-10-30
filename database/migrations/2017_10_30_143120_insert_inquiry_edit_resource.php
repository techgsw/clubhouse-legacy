<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertInquiryEditResource extends Migration
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
                'code' => 'inquiry_edit',
                'description' => "Can edit an inquiry, e.g. to rate it."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'inquiry_edit',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'inquiry_edit',
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
        DB::delete('delete from resource_role where resource_code = "inquiry_edit"');
        DB::delete('delete from resource where code = "inquiry_edit"');
    }
}
