<?php

use App\JobTagWhiteList;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableJobTagWhiteList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_tag_white_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag_name', 255)->unique();
        });

        collect([
            'Analytics',
            'Communications',
            'Corporate Partnerships',
            'Creative Design',
            'CRM',
            'Event Sales',
            'Group Sales',
            'Human Resources',
            'Inside Sales',
            'Internship',
            'Marketing',
            'Operations',
            'Premium Hospitality',
            'Premium Sales',
            'Public Relations',
            'Social Media',
            'Strategy',
            'Student',
            'Ticket Operations',
            'Ticket Sales',
            'Ticket Services',
        ])->each(function ($listItem) {
            JobTagWhiteList::create(['tag_name' => $listItem]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_tag_white_list');
    }
}
