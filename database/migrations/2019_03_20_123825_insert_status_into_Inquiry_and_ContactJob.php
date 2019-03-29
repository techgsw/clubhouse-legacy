<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertStatusIntoInquiryAndContactJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('inquiry', function (Blueprint $table) {
            $table->string('status', 50)->nullable(true)->default(null);
        });
        Schema::table('contact_job', function (Blueprint $table) {
            $table->string('status', 50)->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('inquiry', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('contact_job', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
