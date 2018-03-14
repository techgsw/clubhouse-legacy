<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactFollowUp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->integer('follow_up_user_id')->unsigned()->nullable()->default(null);
            $table->foreign('follow_up_user_id')->references('id')->on('user');
            $table->timestamp('follow_up_date')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->dropForeign([
                'follow_up_user_id'
            ]);
        });
        Schema::table('contact', function (Blueprint $table) {
            $table->dropColumn('follow_up_user_id');
            $table->dropColumn('follow_up_date');
        });
    }
}
