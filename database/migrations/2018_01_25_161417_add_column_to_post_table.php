<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post', function (Blueprint $table) {
            $table->string('post_type_code')->default('blog');
        });

        Schema::table('post', function (Blueprint $table) {
            $table->foreign('post_type_code')->references('code')->on('post_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post', function (Blueprint $table) {
            $table->dropForeign('post_type_code');
        });

        Schema::table('post', function (Blueprint $table) {
            $table->dropColumn('post_type_code');
        });
    }
}
