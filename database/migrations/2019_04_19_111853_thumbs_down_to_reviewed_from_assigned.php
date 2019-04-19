<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ThumbsDownToReviewedFromAssigned extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        $inquiries = DB::table('inquiry as i')
                        ->where('i.pipeline_id', '=', '1')
                        ->whereIn('i.status', ['halted', 'paused'])
                        ->update(['i.pipeline_id' => 2]);

        $contact_job = DB::table('contact_job as cj')
                        ->where('cj.pipeline_id', '=', '1')
                        ->whereIn('cj.status', ['halted', 'paused'])
                        ->update(['cj.pipeline_id' => 2]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
