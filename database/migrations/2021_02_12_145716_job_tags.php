<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_tag', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')->references('id')->on('job');
            $table->string('tag_name', 255);
            $table->foreign('tag_name')->references('name')->on('tag');
        });
        Schema::create('tag_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag_name', 255);
            $table->foreign('tag_name')->references('name')->on('tag');
            $table->string('type', 255);
        });
        DB::table('resource')->Insert(
            [
                'code' => 'tag_type_delete',
                'description' => 'Can delete tags locked down to associated types.',
            ]
        );
        DB::table('resource')->Insert(
            [
                'code' => 'tag_type_create',
                'description' => 'Can create tags locked down to associated types.',
            ]
        );
        DB::table('resource_role')->Insert(
            [
                [
                    'role_code' => 'administrator',
                    'resource_code' => 'tag_type_delete',
                ],
                [
                    'role_code' => 'superuser',
                    'resource_code' => 'tag_type_delete',
                ],
                [
                    'role_code' => 'administrator',
                    'resource_code' => 'tag_type_create',
                ],
                [
                    'role_code' => 'superuser',
                    'resource_code' => 'tag_type_create',
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('resource_role')->where('resource_code', '=', 'tag_type_create')->delete();
        DB::table('resource_role')->where('resource_code', '=', 'tag_type_delete')->delete();
        DB::table('resource')->where('code', '=', 'tag_type_create')->delete();
        DB::table('resource')->where('code', '=', 'tag_type_delete')->delete();

        Schema::dropIfExists('job_tag');
        Schema::dropIfExists('tag_type');
    }
}
