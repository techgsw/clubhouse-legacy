<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertPipelineIdIntoInquiryAndContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // need to insert pipeline id into inquiry and contact_job
        Schema::table('inquiry', function (Blueprint $table) {
            $table->unsignedInteger('pipeline_id')->nullable(false)->default(1);
            $table->foreign('pipeline_id')->references('id')->on('pipeline');
        });
        Schema::table('contact_job', function (Blueprint $table) {
            $table->unsignedInteger('pipeline_id')->nullable(false)->default(1);
            $table->foreign('pipeline_id')->references('id')->on('pipeline');
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
        DB::delete('delete from inquiry where pipeline_id > 0');
        DB::delete('delete from contact_job where pipeline_id > 0');
    }
}
