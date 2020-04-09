<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactSecondaryEmailPhone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->string('secondary_email', 255)->nullable();
            $table->string('secondary_phone', 255)->nullable();
        });
        Schema::table('profile', function (Blueprint $table) {
            $table->string('secondary_email', 255)->nullable();
            $table->string('secondary_phone', 255)->nullable();
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
            $table->dropColumn('secondary_email');
            $table->dropColumn('secondary_phone');
        });
        Schema::table('profile', function (Blueprint $table) {
            $table->dropColumn('secondary_email');
            $table->dropColumn('secondary_phone');
        });
    }
}
