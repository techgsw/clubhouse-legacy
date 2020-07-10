<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MentorSocialMediaLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentor_social_media_link', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mentor_id')->unsigned()->nullable(false);
            $table->foreign('mentor_id')->references('id')->on('mentor');
            $table->string('social_media_type');
            $table->string('link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentor_social_media_link');
    }
}
