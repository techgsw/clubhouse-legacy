<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCodeToEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //career-services, webinars and memberships
        DB::table('email')->Insert(
            [
                'code' => "career_services", 
                'name' => 'Career Service Purchase Notifications', 
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        );

        DB::table('email')->Insert(
            [
                'code' => "webinars", 
                'name' => 'Webinar Purchase Notifications', 
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
        );
        DB::table('email')->Insert(
            [
                'code' => "memberships", 
                'name' => 'Membership Purchase Notifications', 
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
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
        //
        DB::table('email')->where('code', '=', 'memberships')->delete();
        DB::table('email')->where('code', '=', 'webinars')->delete();
        DB::table('email')->where('code', '=', 'career_services')->delete();

    }
}
