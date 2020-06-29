<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProfileSurveyQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile', function(Blueprint $table) {
            $table->string('works_in_sports_years_range')->nullable();
            $table->json('planned_services')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile', function(Blueprint $table) {
            $table->dropColumn('works_in_sports_years_range');
            $table->dropColumn('planned_services');
        });
    }
}
