<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJobInvitationColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add response code table to mantain possible responses from users
        Schema::create('job_interest_response', function (Blueprint $table) {
            $table->string('code', 45)->unique();
            $table->primary('code');
            $table->string('title', 45);

            $table->string('description', 255);
        });

        DB::table('job_interest_response')->insert(
            [
                ['code' => 'interested', 'title' => 'Interested', 'description' => 'User is interested in the job invitation.'],
                ['code' => 'not-interested', 'title' => 'Not Interested', 'description' => 'User is not interested in the job invitation.'],
                ['code' => 'do-not-contact', 'title' => 'Do Not Contact', 'description' => 'User does not wish to be contacted again.']
            ]
        );
        
        Schema::table('contact_job', function (Blueprint $table) {
            $table->string('job_interest_token', 256)->nullable();
            $table->dateTime('job_interest_request_date')->nullable();
            $table->string('job_interest_response_code', 45)->nullable();
            $table->string('job_interest_negative_response', 45)->nullable();
            $table->string('job_interest_negative_response_description', 255)->nullable();
            $table->dateTime('job_interest_response_date')->nullable();
        });

        Schema::table('contact', function (Blueprint $table) {
            $table->boolean('do_not_contact')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contact_job', function (Blueprint $table) {
            $table->dropColumn('job_interest_token');
            $table->dropColumn('job_interest_response_code');
            $table->dropColumn('job_interest_response_date');
            $table->dropColumn('job_interest_request_date');
        });

        Schema::table('contact', function (Blueprint $table) {
            $table->dropColumn('do_not_contact');
        });

        Schema::dropIfExists('job_interest_response');
    }
}
