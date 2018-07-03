<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMentorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentor', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contact_id')->unsigned();
            $table->string('description');
            $table->timestamps();
        });

        DB::table('resource')->insert(
            array(
                'code' => 'mentor_show',
                'description' => "Can view mentors."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_show',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'mentor_edit',
                'description' => "Can edit mentors."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_edit',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_edit',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource')->insert(
            array(
                'code' => 'mentor_create',
                'description' => "Can create mentors."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_create',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'mentor_create',
                'role_code' => 'administrator'
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
        Schema::dropIfExists('mentor');
        DB::table('resource_role')->where('resource_code', 'mentor_show')->delete();
        DB::table('resource')->where('code', 'mentor_show')->delete();
        DB::table('resource_role')->where('resource_code', 'mentor_create')->delete();
        DB::table('resource')->where('code', 'mentor_create')->delete();
        DB::table('resource_role')->where('resource_code', 'mentor_edit')->delete();
        DB::table('resource')->where('code', 'mentor_edit')->delete();
    }
}
