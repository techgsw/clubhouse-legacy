<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('job', function (Blueprint $table) {
            $table->string('organization');
            $table->string('league')->nullable()->default(null);
            $table->string('job_type')->nullable()->default(null);
            $table->string('city');
            $table->string('state');
            $table->boolean('open')->default(true);
            $table->string('image_url');
            $table->timestamp('edited_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('job', function (Blueprint $table) {
            $table->dropColumn('organization');
            $table->dropColumn('league');
            $table->dropColumn('job_type');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('image_url');
            $table->dropColumn('edited_at');
        });
    }
}
