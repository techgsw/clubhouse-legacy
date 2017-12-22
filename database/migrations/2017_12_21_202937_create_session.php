<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('description')->nullable()->default(NULL);
            $table->string('image_url')->nullable()->default(NULL);
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session');
    }
}
