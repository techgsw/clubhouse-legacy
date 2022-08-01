<?php

use App\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class RemoveDeprecatedJobSeekingTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        collect([
            'mid_level',
            'entry_level_management',
            'mid_level_management',
            'executive',
        ])->each(function ($type) {
            Profile::where('job_seeking_type', $type)->each(function (Profile $profile) {
                $profile->update(['job_seeking_type' => null]);
            });
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
    }
}
