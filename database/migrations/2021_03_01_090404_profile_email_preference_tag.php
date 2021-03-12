<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProfileEmailPreferenceTag extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_email_preference_tag_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned();
            $table->foreign('profile_id')->references('id')->on('profile');
            $table->integer('tag_type_id')->unsigned();
            $table->foreign('tag_type_id')->references('id')->on('tag_type');
        });

        // We were not using email_preference_new_job before this. It is now an "opt out of all"
        // switch, but the user will not get emails until they set their job type preferences
        // in their profile. Changing this for UX purposes

        // CAUTION: this is expecting certain data in the production db.
        DB::statement('INSERT INTO profile_email_preference_tag_type (tag_type_id, profile_id) '.
           '(SELECT 4, id FROM profile WHERE department_goals_ticket_sales=1);');
        DB::statement('INSERT INTO profile_email_preference_tag_type (tag_type_id, profile_id) '.
           '(SELECT 2, id FROM profile WHERE department_goals_ticket_sales=1);');
        DB::statement('INSERT INTO profile_email_preference_tag_type (tag_type_id, profile_id) '.
           '(SELECT 9, id FROM profile WHERE department_goals_ticket_sales=1);');
        DB::statement('INSERT INTO profile_email_preference_tag_type (tag_type_id, profile_id) '.
           '(SELECT 5, id FROM profile WHERE department_goals_premium_sales=1);');
        DB::statement('INSERT INTO profile_email_preference_tag_type (tag_type_id, profile_id) '.
           '(SELECT 7, id FROM profile WHERE department_goals_premium_sales=1);');
        DB::statement('INSERT INTO profile_email_preference_tag_type (tag_type_id, profile_id) '.
           '(SELECT 12, id FROM profile WHERE department_goals_social_media=1);');
        DB::statement('INSERT INTO profile_email_preference_tag_type (tag_type_id, profile_id) '.
           '(SELECT 6, id FROM profile WHERE department_goals_sponsorship_sales=1 OR department_goals_sponsorship_activation=1);');
        DB::statement('INSERT INTO profile_email_preference_tag_type (tag_type_id, profile_id) '.
           '(SELECT 1, id FROM profile WHERE department_goals_marketing=1);');
        DB::statement('INSERT INTO profile_email_preference_tag_type (tag_type_id, profile_id) '.
           '(SELECT 11, id FROM profile WHERE department_goals_sponsorship_activation=1);');
        DB::statement('INSERT INTO profile_email_preference_tag_type (tag_type_id, profile_id) '.
           '(SELECT 14, id FROM profile WHERE department_goals_marketing=1);');

        // failing with weird error about not supporting json types. not sure what's happening.
        // need to run this manually:
        // ALTER TABLE profile MODIFY COLUMN email_preference_new_job tinyint(1) NOT NULL DEFAULT '1';
        // UPDATE profile SET email_preference_new_job=1;
        //
        //Schema::table('profile', function (Blueprint $table) {
        //    $table->tinyInteger('email_preference_new_job')->nullable(false)->default(1)->change();
        //});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->boolean('email_preference_new_job')->default(false)->change();
        });
        Schema::dropIfExists('profile_email_preference_tag_type');
    }
}
