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
    }

    public function down()
    {
        Schema::dropIfExists('product_tag');
        Schema::dropIfExists('product_image');
        Schema::dropIfExists('product_option_role');
        Schema::dropIfExists('product_option');
        Schema::dropIfExists('product');
    }
}
