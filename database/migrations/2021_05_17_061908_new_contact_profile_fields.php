<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewContactProfileFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->string('ethnicity')->nullable();
            $table->string('gender')->nullable();
            $table->string('job_seeking_region')->nullable();
        });

        Schema::create('contact_email_preference_tag_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unsigned();
            $table->foreign('contact_id')->references('id')->on('contact');
            $table->integer('tag_type_id')->unsigned();
            $table->foreign('tag_type_id')->references('id')->on('tag_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_email_preference_tag_type');
        Schema::table('contact', function (Blueprint $table) {
            $table->dropColumn([
                'ethnicity',
                'gender',
                'job_seeking_region'
            ]);
        });
    }
}
