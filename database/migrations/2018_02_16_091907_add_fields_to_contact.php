<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Profile;

class AddFieldsToContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->string('resume_url')->nullable()->default(NULL);
            $table->string('job_seeking_status')->nullable()->default(NULL);
            $table->string('job_seeking_type')->nullable()->default(NULL);
        });

        foreach (Profile::all() as $profile) {
            $profile->user->contact->job_seeking_status = $profile->job_seeking_status;
            $profile->user->contact->job_seeking_type = $profile->job_seeking_type;
            $profile->user->contact->resume_url = $profile->resume_url;
            $profile->user->contact->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->dropColumn([
                'resume_url',
                'job_seeking_status',
                'job_seeking_type'
            ]);
        });
    }
}
