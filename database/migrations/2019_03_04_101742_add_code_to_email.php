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
        //
        DB::table('email')->Insert(
            [
            'code' => "purchase_notification", 
            'name' => 'Purchase Notifications', 
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
        DB::table('email')->where('code', '=', 'purchase_notification')->delete();
    }
}
