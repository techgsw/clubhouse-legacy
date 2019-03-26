<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactoringRatingIntoPipeline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Add reason column to the inquiry on the contactjob
        Schema::table('inquiry', function (Blueprint $table) {
            $table->string('reason', 50)->nullable(true)->default(null);
        });
        Schema::table('contact_job', function (Blueprint $table) {
            $table->string('reason', 50)->nullable(true)->default(null);
        });

        DB::update("UPDATE `contact_job` SET `pipeline_id` = 2 WHERE `rating` = -1 OR `rating` = 1");
        DB::update("UPDATE `inquiry` SET `pipeline_id` = 2 WHERE `rating` = -1 OR `rating` = 1");

        DB::update("UPDATE `inquiry` SET `status` = 'halted' WHERE `rating` = -1");
        DB::update("UPDATE `contact_job` SET `status` = 'halted' WHERE `rating` = -1");

        Schema::table('inquiry', function (Blueprint $table) {
            $table->dropColumn('rating');
        });
        Schema::table('contact_job', function (Blueprint $table) {
            $table->dropColumn('rating');
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
            $table->dropColumn('reason');
        });
        Schema::table('contact_job', function (Blueprint $table) {
            $table->dropColumn('reason');
        });

        Schema::table('inquiry', function (Blueprint $table) {
            $table->integer('rating')->nullable()->default(NULL);
        });
        Schema::table('contact_job', function (Blueprint $table) {
            $table->integer('rating')->nullable()->default(NULL);
        });
    }
}
