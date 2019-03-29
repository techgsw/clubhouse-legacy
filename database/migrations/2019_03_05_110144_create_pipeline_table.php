<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePipelineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Creating the new table recruiting type
        Schema::create('pipeline', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
        });

        // insert step 1 - 10
        DB::table('pipeline')->insert(
            array(
                'name' => 'Step 1',
            )
        );
        DB::table('pipeline')->insert(
            array(
                'name' => 'Step 2',
            )
        );
        DB::table('pipeline')->insert(
            array(
                'name' => 'Step 3',
            )
        );
        DB::table('pipeline')->insert(
            array(
                'name' => 'Step 4',
            )
        );
        DB::table('pipeline')->insert(
            array(
                'name' => 'Step 5',
            )
        );
        DB::table('pipeline')->insert(
            array(
                'name' => 'Step 6',
            )
        );
        DB::table('pipeline')->insert(
            array(
                'name' => 'Step 7',
            )
        );
        DB::table('pipeline')->insert(
            array(
                'name' => 'Step 8',
            )
        );
        DB::table('pipeline')->insert(
            array(
                'name' => 'Step 9',
            )
        );
        DB::table('pipeline')->insert(
            array(
                'name' => 'Step 10',
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
        Schema::dropIfExists('pipeline');
    }
}
