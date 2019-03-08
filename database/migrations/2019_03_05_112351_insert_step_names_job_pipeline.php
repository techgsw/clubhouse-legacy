<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertStepNamesJobPipeline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::table('job_pipeline')->insert(
            array(
                'name' => 'Applied',
                'description' => 'A contact has applied or been assigned a job.',
                'pipeline_id' => 1
            )
        );
        DB::table('job_pipeline')->insert(
            array(
                'name' => 'Contacted',
                'description' => 'Applicant has been contacted.',
                'pipeline_id' => 2
            )
        );
        DB::table('job_pipeline')->insert(
            array(
                'name' => 'Qualified',
                'description' => 'Applicant has been deemed qualified for the position.',
                'pipeline_id' => 3
            )
        );
        DB::table('job_pipeline')->insert(
            array(
                'name' => 'Submittable',
                'description' => 'Applicant is ready for submission to the job provider',
                'pipeline_id' => 4
            )
        );
        DB::table('job_pipeline')->insert(
            array(
                'name' => 'Interviewed',
                'description' => 'Applicant has been interviewed.',
                'pipeline_id' => 5
            )
        );
        DB::table('job_pipeline')->insert(
            array(
                'name' => 'Hired',
                'description' => 'Applicant has been hired!',
                'pipeline_id' => 6
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::delete('delete from job_pipeline where name = "Applied"');
        DB::delete('delete from job_pipeline where name = "Contacted"');
        DB::delete('delete from job_pipeline where name = "Qualified"');
        DB::delete('delete from job_pipeline where name = "Submittable"');
        DB::delete('delete from job_pipeline where name = "Interviewed"');
        DB::delete('delete from job_pipeline where name = "Hired"');


    }
}
