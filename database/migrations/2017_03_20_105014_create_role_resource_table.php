<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleResourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('code')->unique();
            $table->string('description');
        });

        Schema::create('resource', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('code')->unique();
            $table->string('description');
        });

        Schema::create('resource_role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('role_code');
            $table->string('resource_code');
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('user_id')->unsigned();
            $table->string('role_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('resource_role');
        Schema::dropIfExists('role');
        Schema::dropIfExists('resource');
    }
}
