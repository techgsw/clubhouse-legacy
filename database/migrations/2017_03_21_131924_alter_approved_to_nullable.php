<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterApprovedToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question', function (Blueprint $table) {
            $table->boolean('approved')->nullable()->default(null)->change();
        });

        Schema::table('answer', function (Blueprint $table) {
            $table->boolean('approved')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question', function (Blueprint $table) {
            $table->boolean('approved')->default(false)->change();
        });

        Schema::table('answer', function (Blueprint $table) {
            $table->boolean('approved')->default(false)->change();
        });
    }
}
