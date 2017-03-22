<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleResourceRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_role', function (Blueprint $table) {
            $table->foreign('role_code')->references('code')->on('role');
            $table->foreign('resource_code')->references('code')->on('resource');
        });

        Schema::table('role_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('role_code')->references('code')->on('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resource_role', function (Blueprint $table) {
            $table->dropForeign(['role_code', 'resource_code']);
        });

        Schema::table('role_user', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'role_code']);
        });
    }
}
