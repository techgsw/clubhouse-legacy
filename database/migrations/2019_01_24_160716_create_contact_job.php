<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_job', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('admin_user_id')->unsigned();
            $table->integer('job_id')->unsigned();
            $table->integer('rating')->nullable()->default(null);
            $table->string('resume')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('admin_user_id')->references('id')->on('user');
            $table->foreign('job_id')->references('id')->on('job');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_job');
    }
}
