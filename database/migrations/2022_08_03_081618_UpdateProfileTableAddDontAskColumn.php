<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProfileTableAddDontAskColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::table('profile', function (Blueprint $table) {
            $table->boolean('dont_ask')->after('user_id')->default(false);
        });
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
        Schema::table('profile', function(Blueprint $table) {
            $table->dropColumn('dont_ask');
        });
        Schema::enableForeignKeyConstraints();
    }
}
