<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MentorRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentor_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mentor_id')->unsigned()->nullable();
            $table->foreign('mentor_id')->references('id')->on('mentor');
            $table->integer('user_id')->unsigned()->nullable(false);
            $table->foreign('user_id')->references('id')->on('user');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
        Schema::table('mentor', function(Blueprint $table) {
            $table->string('calendly_link', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentor_request');
        Schema::table('mentor', function (Blueprint $table) {
            $table->dropColumn('calendly_link');
        });
    }
}
