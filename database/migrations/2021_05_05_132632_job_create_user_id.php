<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobCreateUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job', function (Blueprint $table) {
            $table->integer('job_create_user_id')->unsigned();
        });
        
        DB::statement('UPDATE job SET job_create_user_id = user_id');

        Schema::table('job', function (Blueprint $table) {
            $table->integer('job_create_user_id')->unsigned()->nullable(false)->change();
            $table->foreign('job_create_user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job', function (Blueprint $table) {
            $table->dropForeign('job_job_create_user_id_foreign');
            $table->dropColumn('job_create_user_id');
        });
    }
}
