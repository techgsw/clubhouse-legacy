<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEditedAtToQuestionAndAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question', function (Blueprint $table) {
            $table->timestamp('edited_at')->nullable();
        });

        Schema::table('answer', function (Blueprint $table) {
            $table->timestamp('edited_at')->nullable();
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
            $table->dropColumn('edited_at');
        });

        Schema::table('answer', function (Blueprint $table) {
            $table->dropColumn('edited_at');
        });
    }
}
