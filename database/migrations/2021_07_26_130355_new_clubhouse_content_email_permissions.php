<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewClubhouseContentEmailPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->boolean('email_preference_new_content_webinars')->default(false);
            $table->boolean('email_preference_new_content_blogs')->default(false);
            $table->boolean('email_preference_new_content_mentors')->default(false);
        });

        //TODO need to populate these users with the correct info

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->dropColumn('email_preference_new_content_webinars');
            $table->dropColumn('email_preference_new_content_blogs');
            $table->dropColumn('email_preference_new_content_mentors');
        });
    }
}
