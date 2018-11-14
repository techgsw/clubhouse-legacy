<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimePreferenceToMentors extends Migration
{
    public function up()
    {
        Schema::table('mentor', function (Blueprint $table) {
            $table->string('timezone')->nullable()->default(NULL);
            $table->string('day_preference_1')->nullable()->default(NULL);
            $table->string('time_preference_1')->nullable()->default(NULL);
            $table->string('day_preference_2')->nullable()->default(NULL);
            $table->string('time_preference_2')->nullable()->default(NULL);
            $table->string('day_preference_3')->nullable()->default(NULL);
            $table->string('time_preference_3')->nullable()->default(NULL);
        });
    }

    public function down()
    {
        Schema::table('mentor', function (Blueprint $table) {
            $table->dropColumn([
                'timezone',
                'day_preference_1',
                'time_preference_1',
                'day_preference_2',
                'time_preference_2',
                'day_preference_3',
                'time_preference_3'
            ]);
        });
    }
}
