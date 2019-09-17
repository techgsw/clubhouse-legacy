<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->timestamps();
        });

        DB::table('job_status')->insert(
            array(
                'name' => 'Open',
                'code' => 'open'
            )
        );

        DB::table('job_status')->insert(
            array(
                'name' => 'Closed',
                'code' => 'closed'
            )
        );

        DB::table('job_status')->insert(
            array(
                'name' => 'Expired',
                'code' => 'expired'
            )
        );

        Schema::table('job', function (Blueprint $table) {
            $table->integer('job_status_id')->unsigned()->nullable(false)->default(1);
            $table->foreign('job_status_id')->references('id')->on('job_status');
            $table->timestamp('extended_at')->nullable();
        });

        DB::table('job')->update([
            // if the job has been upgraded recently then we want to use that date for reference
            'extended_at' => DB::raw('(CASE WHEN upgraded_at IS NULL THEN created_at ELSE upgraded_at END)'),
            // see constants.php
            'job_status_id' => DB::raw('(CASE open WHEN 0 THEN 2 ELSE 1 END)')
        ]);

        Schema::table('job', function (Blueprint $table) {
            $table->dropColumn('open');
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
            $table->tinyInteger('open')->nullable(false)->default(1);
        });

        // add back to open by job status. default any other status to closed. see constants.php
        DB::table('job')->update([
            'open' => DB::raw('(CASE job_status_id WHEN 1 THEN 1 ELSE 0 END)')
        ]);

        Schema::table('job', function (Blueprint $table) {
            $table->dropForeign(['job_status_id']);
            $table->dropColumn('job_status_id');
            $table->dropColumn('extended_at');
        });

        Schema::dropIfExists('job_status');
    }
}
