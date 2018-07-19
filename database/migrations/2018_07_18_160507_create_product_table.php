<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('product_option', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->string('name');
            $table->text('description');
            $table->float('price');
            $table->integer('quantity')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('product');
        });

        Schema::create('product_option_role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('product_option_id')->unsigned();
            $table->string('role_code');

            $table->foreign('product_option_id')->references('id')->on('product_option');
            $table->foreign('role_code')->references('code')->on('role');
        });

        Schema::create('product_image', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('image_id')->unsigned();
            $table->integer('product_id')->unsigned();

            $table->foreign('image_id')->references('id')->on('image');
            $table->foreign('product_id')->references('id')->on('product');
        });

        Schema::create('product_tag', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('tag_name');
            $table->integer('product_id')->unsigned();

            $table->foreign('tag_name')->references('name')->on('tag');
            $table->foreign('product_id')->references('id')->on('product');
        });

        DB::table('resource')->insert(
            array(
                'code' => 'product_show',
                'description' => "Can view products."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'product_show',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'product_show',
                'role_code' => 'administrator'
            )
        );

        DB::table('resource')->insert(
            array(
                'code' => 'product_edit',
                'description' => "Can edit products."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'product_edit',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'product_edit',
                'role_code' => 'administrator'
            )
        );

        DB::table('resource')->insert(
            array(
                'code' => 'product_create',
                'description' => "Can create products."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'product_create',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'product_create',
                'role_code' => 'administrator'
            )
        );

        DB::table('resource')->insert(
            array(
                'code' => 'product_admin',
                'description' => "Can access admin view of products."
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'product_admin',
                'role_code' => 'superuser'
            )
        );
        DB::table('resource_role')->insert(
            array(
                'resource_code' => 'product_admin',
                'role_code' => 'administrator'
            )
        );
    }

    public function down()
    {
        DB::table('resource_role')->where('resource_code', 'product_admin')->delete();
        DB::table('resource')->where('code', 'product_admin')->delete();
        DB::table('resource_role')->where('resource_code', 'product_show')->delete();
        DB::table('resource')->where('code', 'product_show')->delete();
        DB::table('resource_role')->where('resource_code', 'product_create')->delete();
        DB::table('resource')->where('code', 'product_create')->delete();
        DB::table('resource_role')->where('resource_code', 'product_edit')->delete();
        DB::table('resource')->where('code', 'product_edit')->delete();

        Schema::dropIfExists('product_tag');
        Schema::dropIfExists('product_image');
        Schema::dropIfExists('product_option_role');
        Schema::dropIfExists('product_option');
        Schema::dropIfExists('product');
    }
}
