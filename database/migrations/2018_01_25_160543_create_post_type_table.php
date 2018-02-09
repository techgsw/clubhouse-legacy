<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_type', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('code')->unique();
            $table->string('description')->unique();
        });

        DB::table('post_type')->insert(
            array(
                'code' => 'blog',
                'description' => "A standard blog post."
            )
        );

        DB::table('post_type')->insert(
            array(
                'code' => 'session',
                'description' => "A client session or engagement."
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
        Schema::dropIfExists('post_type');
    }
}
