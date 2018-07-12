<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeadshotToContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->integer('headshot_image_id')->unsigned()->nullable()->default(NULL);
            $table->foreign('headshot_image_id')->references('id')->on('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact', function (Blueprint $table) {
            $table->dropForeign('headshot_image_id');
            $table->dropColumn('headshot_image_id');
        });
    }
}
