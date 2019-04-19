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
        DB::update("UPDATE `job_pipeline` SET `name` = 'Reviewed' WHERE `name` = 'Contacted'");
        DB::update("UPDATE `job_pipeline` SET `description` = 'Applicant has been reviewed.' WHERE `description` = 'Applicant has been contacted.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::update("UPDATE `job_pipeline` SET `name` = 'Contacted' WHERE `name` = 'Reviewed'");
        DB::update("UPDATE `job_pipeline` SET `description` = 'Applicant has been contacted.' WHERE `description` = 'Applicant has been reviewed.'");
    }
}
