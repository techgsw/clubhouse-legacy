<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AnswerEditResource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('resource')->insert([
            'code' => 'answer_edit',
            'description' => 'Can edit any answer.'
        ]);

        DB::table('resource_role')->insert(
            array(
                array(
                    'resource_code' => 'answer_edit',
                    'role_code' => 'administrator'
                ),
                array(
                    'resource_code' => 'answer_edit',
                    'role_code' => 'moderator'
                ),
                array(
                    'resource_code' => 'answer_edit',
                    'role_code' => 'superuser'
                )
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
        DB::delete('delete from resource_role where resource_code = "answer_edit"');
        DB::delete('delete from resource where code = "answer_edit"');
    }
}
