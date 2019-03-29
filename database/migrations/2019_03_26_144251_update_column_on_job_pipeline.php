<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnOnJobPipeline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('job_pipeline')
            ->where('name', 'Submittable')
            ->update(['name' => 'Submitted']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::table('job_pipeline')
            ->where('name', 'Submitted')
            ->update(['name' => 'Submittable']);
    }
}
