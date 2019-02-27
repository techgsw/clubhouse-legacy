<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecruitingTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Creating the new table recruiting type
        Schema::create('recruiting_type', function (Blueprint $table) {
            $table->string('code', 50)->unique();
            $table->string('description');
        });

        // Insert Recruiting Types
        DB::table('recruiting_type')->insert(
            array(
                'code' => 'active',
                'description' => 'Recruiter is actively recruiting'
            )
        );
        DB::table('recruiting_type')->insert(
            array(
                'code' => 'passive',
                'description' => 'Recruiter is not active and running a pass-through.'
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
        // Drop the table if it exists
        Schema::dropIfExists('recruiting_type');
    }
}
