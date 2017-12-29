<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('note', function (Blueprint $table) {
            $table->increments('id');
            // Foreign keys
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user');
            // Fields
            $table->integer('notable_id')->nullable()->default(NULL);
            $table->string('notable_type')->nullable()->default(NULL);
            $table->text('content')->nullable()->default(NULL);
            $table->timestamps();
        });

        // ACL
        // create-profile-note
        DB::table('resource')->insert(
            array(
                'code' => 'profile_note_create',
                'description' => "Can create a profile note."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_note_create',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_note_create',
                'role_code' => 'superuser'
            )
        );
        // view-profile-note
        DB::table('resource')->insert(
            array(
                'code' => 'profile_note_show',
                'description' => "Can view a profile note."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_note_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'profile_note_show',
                'role_code' => 'superuser'
            )
        );
        // create-inquiry-note
        DB::table('resource')->insert(
            array(
                'code' => 'inquiry_note_create',
                'description' => "Can create an inquiry note."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'inquiry_note_create',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'inquiry_note_create',
                'role_code' => 'superuser'
            )
        );
        // view-inquiry-note
        DB::table('resource')->insert(
            array(
                'code' => 'inquiry_note_show',
                'description' => "Can view an inquiry note."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'inquiry_note_show',
                'role_code' => 'administrator'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'inquiry_note_show',
                'role_code' => 'superuser'
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
        Schema::dropIfExists('note');

        DB::delete('delete from resource_role where resource_code = "profile_note_create"');
        DB::delete('delete from resource where code = "profile_note_create"');
        DB::delete('delete from resource_role where resource_code = "profile_note_show"');
        DB::delete('delete from resource where code = "profile_note_show"');
        DB::delete('delete from resource_role where resource_code = "inquiry_note_create"');
        DB::delete('delete from resource where code = "inquiry_note_create"');
        DB::delete('delete from resource_role where resource_code = "inquiry_note_show"');
        DB::delete('delete from resource where code = "inquiry_note_show"');
    }
}
