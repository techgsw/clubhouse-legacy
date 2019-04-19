<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveContactToReviewed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::update("UPDATE `job_pipeline` SET `name` = 'Reviewed' WHERE `id` = 2");
        DB::update("UPDATE `job_pipeline` SET `description` = 'Applicant has been reviewed.' WHERE `id` = 2");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::update("UPDATE `job_pipeline` SET `name` = 'Contacted' WHERE `id` = 2");
        DB::update("UPDATE `job_pipeline` SET `description` = 'Applicant has been contacted.' WHERE `id` = 2");
    }
}
