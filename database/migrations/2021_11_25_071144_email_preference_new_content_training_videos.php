<?php

use App\Profile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailPreferenceNewContentTrainingVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->boolean('email_preference_new_content_training_videos')->default(false);
        });
        Profile::orWhere('email_preference_new_content_webinars', true)
            ->orWhere('email_preference_new_content_blogs', true)
            ->orWhere('email_preference_new_content_mentors', true)
            ->update(['email_preference_new_content_training_videos' => true]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->dropColumn('email_preference_new_content_training_videos');
        });
    }
}
