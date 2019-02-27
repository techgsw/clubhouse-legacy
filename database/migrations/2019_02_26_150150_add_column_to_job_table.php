<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('job', function (Blueprint $table) {
            $table->string('recruiting_type_code', 50)->nullable(false)->default("passive");
            $table->foreign('recruiting_type_code')->references('code')->on('recruiting_type');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('job', function (Blueprint $table) {
            $table->dropForeign('recruiting_type_code');
            $table->dropColumn('recruiting_type_code');
        });
    }
}
